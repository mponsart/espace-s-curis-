<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\VolunteerModel;

final class PublicFormController extends BaseController
{
    private VolunteerModel $volunteers;

    public function __construct(\App\Core\App $app)
    {
        parent::__construct($app);
        $this->volunteers = new VolunteerModel();
    }

    public function form(): void
    {
        $token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
        if ($token === '') {
            $this->abort(404, 'Lien invalide.');
        }

        $volunteer = $this->volunteers->findByToken($token);
        if ($volunteer === null) {
            $this->abort(404, 'Ce lien a expire ou est invalide.');
        }

        $values = [
            'last_name' => $volunteer['last_name'] ?? '',
            'first_name' => $volunteer['first_name'] ?? '',
            'gender' => $volunteer['gender'] ?? '',
            'birth_date' => $volunteer['birth_date'] ?? '',
            'birth_place' => $volunteer['birth_place'] ?? '',
            'nationality' => $volunteer['nationality'] ?? '',
            'email' => $volunteer['email'] ?? '',
            'address' => $volunteer['address'] ?? '',
            'postal_code' => $volunteer['postal_code'] ?? '',
            'city' => $volunteer['city'] ?? '',
            'phone' => $volunteer['phone'] ?? '',
            'emergency_name' => $volunteer['emergency_name'] ?? '',
            'emergency_phone' => $volunteer['emergency_phone'] ?? '',
            'consent_rgpd' => (int) ($volunteer['consent_rgpd'] ?? 0),
        ];
        $errors = [];
        $saved = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $values = $this->sanitize($_POST);
            $errors = $this->validate($values);

            if ($errors === []) {
                $this->volunteers->updateForm((int) $volunteer['id'], $values);
                Session::flash('success', 'Merci, vos informations ont bien ete enregistrees.');
                $saved = true;
            }
        }

        $this->render('public/form', [
            'pageTitle' => 'Formulaire benevole',
            'token' => $token,
            'values' => $values,
            'errors' => $errors,
            'saved' => $saved,
        ], 'layouts/public');
    }

    private function sanitize(array $input): array
    {
        return [
            'last_name' => trim((string) ($input['last_name'] ?? '')),
            'first_name' => trim((string) ($input['first_name'] ?? '')),
            'gender' => trim((string) ($input['gender'] ?? '')),
            'birth_date' => trim((string) ($input['birth_date'] ?? '')),
            'birth_place' => trim((string) ($input['birth_place'] ?? '')),
            'nationality' => trim((string) ($input['nationality'] ?? '')),
            'email' => strtolower(trim((string) ($input['email'] ?? ''))),
            'address' => trim((string) ($input['address'] ?? '')),
            'postal_code' => trim((string) ($input['postal_code'] ?? '')),
            'city' => trim((string) ($input['city'] ?? '')),
            'phone' => trim((string) ($input['phone'] ?? '')),
            'emergency_name' => trim((string) ($input['emergency_name'] ?? '')),
            'emergency_phone' => trim((string) ($input['emergency_phone'] ?? '')),
            'consent_rgpd' => isset($input['consent_rgpd']) ? 1 : 0,
        ];
    }

    private function validate(array $values): array
    {
        $errors = [];
        $allowedGenders = ['', 'female', 'male', 'other', 'prefer_not_to_say'];

        if ($values['last_name'] === '') {
            $errors[] = 'Le nom est obligatoire.';
        }

        if ($values['first_name'] === '') {
            $errors[] = 'Le prenom est obligatoire.';
        }

        if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Une adresse email valide est obligatoire.';
        }

        if (!in_array($values['gender'], $allowedGenders, true)) {
            $errors[] = 'Le genre selectionne est invalide.';
        }

        if ($values['birth_date'] !== '' && \DateTimeImmutable::createFromFormat('Y-m-d', $values['birth_date']) === false) {
            $errors[] = 'La date de naissance est invalide.';
        }

        if ($values['consent_rgpd'] !== 1) {
            $errors[] = 'Vous devez accepter le traitement de vos donnees.';
        }

        return $errors;
    }
}