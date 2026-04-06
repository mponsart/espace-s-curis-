<?php
declare(strict_types=1);

namespace App\Core;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class Mailer
{
    public static function sendInvitation(string $toEmail, string $inviteLink, string $expiresAt, ?string &$error = null): bool
    {
        $error = null;
        $enabled = (bool) config('mail.enabled', false);
        if (!$enabled) {
            $error = 'Envoi email desactive dans la configuration.';
            return false;
        }

        $fromEmail = trim((string) config('mail.from_email', ''));
        $fromName = trim((string) config('mail.from_name', (string) config('app.name', 'Collecte Benevoles')));

        if ($fromEmail === '' || !filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
            $error = 'Adresse expediteur invalide (mail.from_email).';
            return false;
        }

        $smtpHost = trim((string) config('mail.smtp.host', ''));
        $smtpPort = (int) config('mail.smtp.port', 587);
        $smtpEncryption = strtolower(trim((string) config('mail.smtp.encryption', 'tls')));
        $smtpUsername = trim((string) config('mail.smtp.username', ''));
        $smtpPassword = (string) config('mail.smtp.password', '');
        $smtpAuth = (bool) config('mail.smtp.auth', true);

        if ($smtpHost === '') {
            $error = 'Hote SMTP manquant (mail.smtp.host).';
            return false;
        }

        if ($smtpAuth && ($smtpUsername === '' || $smtpPassword === '')) {
            $error = 'Identifiants SMTP manquants (mail.smtp.username/password).';
            return false;
        }

        if (!in_array($smtpEncryption, ['', 'tls', 'ssl'], true)) {
            $error = 'Chiffrement SMTP invalide (utiliser "tls", "ssl" ou vide).';
            return false;
        }

        $subject = 'Votre candidature benevole est acceptee - completion du dossier';
        $body = implode("\n", [
            'Bonjour,',
            '',
            'Si vous recevez cet email, cela signifie que votre candidature benevole a ete acceptee.',
            'Ce formulaire sert a completer vos informations dans le cadre de la demarche de finalisation de votre dossier.',
            '',
            'Acceder au formulaire :',
            $inviteLink,
            '',
            'Date limite de reponse : ' . $expiresAt,
            '',
            'Merci et bienvenue,',
            $fromName,
        ]);

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $smtpHost;
            $mail->Port = $smtpPort;
            $mail->SMTPAuth = $smtpAuth;
            $mail->Username = $smtpUsername;
            $mail->Password = $smtpPassword;

            if ($smtpEncryption === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } elseif ($smtpEncryption === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            }

            $mail->CharSet = 'UTF-8';
            $mail->setFrom($fromEmail, $fromName);
            $mail->addReplyTo($fromEmail, $fromName);
            $mail->addAddress($toEmail);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->isHTML(false);
            $mail->send();
        } catch (Exception $exception) {
            $error = 'Echec SMTP: ' . $exception->getMessage();
            return false;
        }

        return true;
    }
}
