<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Security;
use App\Core\Session;
use App\Models\VolunteerModel;

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
            'pageTitle' => 'Benevoles',
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
            $this->abort(404, 'Benevole introuvable.');
        }

        $this->render('admin/volunteer', [
            'pageTitle' => 'Detail benevole',
            'volunteer' => $volunteer,
            'user' => current_user(),
        ]);
    }

    public function invite(): void
    {
        $user = Auth::requireAdmin();
        $generatedLink = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $email = strtolower(trim((string) ($_POST['email'] ?? '')));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                remember_old($_POST);
                Session::flash('error', 'Adresse email invalide.');
                $this->redirect('invite.php');
            }

            $token = Security::token();
            $expiresAt = (new \DateTimeImmutable('+7 days'))->format('Y-m-d H:i:s');
            $this->volunteers->createInvitation($email, $token, $expiresAt);
            $generatedLink = url('form.php?token=' . urlencode($token));
            Session::flash('success', 'Lien d\'invitation genere.');
            clear_old();
        }

        $this->render('admin/invite', [
            'pageTitle' => 'Creer un lien',
            'user' => $user,
            'generatedLink' => $generatedLink,
        ]);
    }

    public function deleteVolunteer(): never
    {
        Auth::requireAdmin();
        $this->validateCsrf();

        $id = (int) ($_POST['id'] ?? 0);
        $volunteer = $this->volunteers->findById($id);
        if ($volunteer === null) {
            Session::flash('error', 'Benevole introuvable.');
            $this->redirect('volunteers.php');
        }

        $this->volunteers->delete($id);
        Session::flash('success', 'Benevole supprime.');
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
        fputcsv($output, ['ID', 'Nom', 'Prenom', 'Email', 'Telephone', 'Ville', 'Date creation'], ';');

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
}