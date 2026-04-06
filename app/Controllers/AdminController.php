<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Mailer;
use App\Core\Security;
use App\Core\Session;
use App\Models\VolunteerModel;
use Dompdf\Dompdf;
use Dompdf\Options;

final class AdminController extends BaseController
{
    private VolunteerModel $volunteers;

    public function __construct(\App\Core\App $app)
    {
        parent::__construct($app);
        $this->volunteers = new VolunteerModel();
    }

    public function dashboard(): void
    {
        $user = Auth::requireAdmin();
        $total = $this->volunteers->countAll();
        $recent = $this->volunteers->recent();

        $this->render('admin/dashboard', [
            'pageTitle' => 'Tableau de bord',
            'user' => $user,
            'totalVolunteers' => $total,
            'recentVolunteers' => $recent,
        ]);
    }

    public function volunteers(): void
    {
        $user = Auth::requireAdmin();
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 10;
        $total = $this->volunteers->countAll();

        $this->render('admin/volunteers', [
            'pageTitle' => 'Bénévoles',
            'user' => $user,
            'volunteers' => $this->volunteers->paginate($page, $perPage),
            'pagination' => [
                'page' => $page,
                'pages' => max(1, (int) ceil($total / $perPage)),
                'total' => $total,
            ],
        ]);
    }

    public function volunteer(): void
    {
        Auth::requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $volunteer = $this->volunteers->findById($id);

        if ($volunteer === null) {
            $this->abort(404, 'Bénévole introuvable.');
        }

        $this->render('admin/volunteer', [
            'pageTitle' => 'Détail bénévole',
            'volunteer' => $volunteer,
            'user' => current_user(),
        ]);
    }

    public function invite(): void
    {
        $user = Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $email = strtolower(trim((string) ($_POST['email'] ?? '')));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                remember_old($_POST);
                Session::flash('error', 'Adresse e-mail invalide.');
                $this->redirect('invite.php');
            }

            $token = Security::token();
            $expiresAt = (new \DateTimeImmutable('+7 days'))->format('Y-m-d H:i:s');
            $this->volunteers->createInvitation($email, $token, $expiresAt);
            $inviteLink = url('form.php?token=' . urlencode($token));

            $mailError = null;
            if (Mailer::sendInvitation($email, $inviteLink, $expiresAt, $mailError)) {
                Session::flash('success', 'Invitation envoyée avec succès au bénévole.');
            } else {
                Session::flash('error', 'Invitation créée, mais e-mail non envoyé. ' . ($mailError ?? 'Vérifiez la configuration e-mail.'));
            }

            clear_old();
        }

        $this->render('admin/invite', [
            'pageTitle' => 'Créer une invitation',
            'user' => $user,
        ]);
    }

    public function deleteVolunteer(): never
    {
        Auth::requireAdmin();
        $this->validateCsrf();

        $id = (int) ($_POST['id'] ?? 0);
        $volunteer = $this->volunteers->findById($id);
        if ($volunteer === null) {
            Session::flash('error', 'Bénévole introuvable.');
            $this->redirect('volunteers.php');
        }

        $this->volunteers->delete($id);
        Session::flash('success', 'Bénévole supprimé.');
        $this->redirect('volunteers.php');
    }

    public function exportCsv(): never
    {
        Auth::requireAdmin();

        $rows = $this->volunteers->exportRows();
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="benevoles-' . date('Ymd-His') . '.csv"');

        $output = fopen('php://output', 'wb');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, ['ID', 'Nom', 'Prénom', 'E-mail', 'Téléphone', 'Ville', 'Date de création'], ';');

        foreach ($rows as $row) {
            fputcsv($output, [
                $row['id'],
                $row['last_name'],
                $row['first_name'],
                $row['email'],
                $row['phone'],
                $row['city'],
                $row['created_at'],
            ], ';');
        }

        fclose($output);
        exit;
    }

    public function exportPdf(): never
    {
        Auth::requireAdmin();

        $rows = $this->volunteers->exportRows();
        $generatedAt = (new \DateTimeImmutable())->format('d/m/Y à H:i');

        $tableRows = [];
        foreach ($rows as $row) {
            $fullName = trim(((string) ($row['first_name'] ?? '')) . ' ' . ((string) ($row['last_name'] ?? '')));
            if ($fullName === '') {
                $fullName = 'Invitation en attente';
            }

            $tableRows[] = sprintf(
                '<tr>' .
                '<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>' .
                '</tr>',
                e((string) ($row['id'] ?? '')),
                e($fullName),
                e((string) ($row['email'] ?? '')),
                e((string) ($row['phone'] ?? '')),
                e((string) ($row['city'] ?? '')),
                e((string) ($row['created_at'] ?? '')),
            );
        }

        if ($tableRows === []) {
            $tableRows[] = '<tr><td colspan="6" class="empty">Aucune donnée disponible.</td></tr>';
        }

        $html = '<!DOCTYPE html>' .
            '<html lang="fr"><head><meta charset="UTF-8"><style>' .
            'body{font-family:DejaVu Sans,sans-serif;color:#111827;font-size:11px;}' .
            '.header{margin-bottom:16px;}' .
            '.title{font-size:20px;font-weight:700;margin:0 0 4px 0;color:#290654;}' .
            '.subtitle{font-size:11px;color:#4b5563;margin:0;}' .
            'table{width:100%;border-collapse:collapse;}' .
            'th,td{border:1px solid #d1d5db;padding:8px;vertical-align:top;}' .
            'th{background:#f3f4f6;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.04em;}' .
            '.empty{text-align:center;color:#6b7280;padding:16px;}' .
            '</style></head><body>' .
            '<div class="header">' .
            '<h1 class="title">Export des bénévoles</h1>' .
            '<p class="subtitle">Généré le ' . e($generatedAt) . '</p>' .
            '</div>' .
            '<table><thead><tr>' .
            '<th>ID</th><th>Nom complet</th><th>E-mail</th><th>Téléphone</th><th>Ville</th><th>Date de création</th>' .
            '</tr></thead><tbody>' . implode('', $tableRows) . '</tbody></table>' .
            '</body></html>';

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="benevoles-' . date('Ymd-His') . '.pdf"');
        echo $dompdf->output();
        exit;
    }
}