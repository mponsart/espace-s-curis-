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
            $error = 'Envoi e-mail désactivé dans la configuration.';
            return false;
        }

        $fromEmail = trim((string) config('mail.from_email', ''));
        $fromName = trim((string) config('mail.from_name', (string) config('app.name', 'Collecte Bénévoles')));

        if ($fromEmail === '' || !filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
            $error = 'Adresse expéditeur invalide (mail.from_email).';
            return false;
        }

        $smtpHost = trim((string) config('mail.smtp.host', ''));
        $smtpPort = (int) config('mail.smtp.port', 587);
        $smtpEncryption = strtolower(trim((string) config('mail.smtp.encryption', 'tls')));
        $smtpUsername = trim((string) config('mail.smtp.username', ''));
        $smtpPassword = (string) config('mail.smtp.password', '');
        $smtpAuth = (bool) config('mail.smtp.auth', true);

        if ($smtpHost === '') {
            $error = 'Hôte SMTP manquant (mail.smtp.host).';
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

        $subject = 'Finalisez votre dossier de bénévolat';
        $expiresDate = date_create($expiresAt);
        $displayExpiresAt = $expiresDate !== false ? $expiresDate->format('d/m/Y à H:i') : $expiresAt;
        $signatureName = 'Le service Ressources Humaines du groupe Speed Cloud';

        $plainBody = implode("\n", [
            'Bonjour,',
            '',
            'Votre candidature bénévole a été acceptée.',
            'Pour finaliser votre dossier, veuillez ouvrir cet e-mail dans un client compatible HTML puis cliquer sur le bouton "Accéder au formulaire".',
            '',
            'Date limite de réponse : ' . $displayExpiresAt,
            '',
            'Cordialement,',
            $signatureName,
        ]);

        $safeSignatureName = htmlspecialchars($signatureName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $safeInviteLink = htmlspecialchars($inviteLink, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $safeExpiresAt = htmlspecialchars($displayExpiresAt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $htmlBody = <<<HTML
<div style="margin:0;padding:0;background-color:#f6f8fc;font-family:Arial,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="padding:28px 24px 8px 24px;">
                            <h1 style="margin:0;font-size:22px;line-height:1.3;color:#111827;">Votre candidature est acceptée</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 24px 0 24px;font-size:15px;line-height:1.6;">
                            <p style="margin:0 0 12px 0;">Bonjour,</p>
                            <p style="margin:0 0 12px 0;">Votre candidature bénévole a été validée. Pour finaliser votre dossier, merci de compléter le formulaire via le bouton ci-dessous.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 24px;text-align:center;">
                            <a href="{$safeInviteLink}" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;font-weight:700;font-size:15px;line-height:1;padding:14px 22px;border-radius:10px;">Accéder au formulaire</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 24px 24px 24px;font-size:14px;line-height:1.6;color:#374151;">
                            <p style="margin:0 0 10px 0;"><strong>Date limite de réponse :</strong> {$safeExpiresAt}</p>
                            <p style="margin:0;">Ce lien est personnel et sécurisé. Merci de ne pas le partager.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 24px;background:#f9fafb;font-size:14px;color:#4b5563;">
                            Cordialement,<br>{$safeSignatureName}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
HTML;

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
            $mail->Body = $htmlBody;
            $mail->AltBody = $plainBody;
            $mail->isHTML(true);
            $mail->send();
        } catch (Exception $exception) {
            $error = 'Échec SMTP : ' . $exception->getMessage();
            return false;
        }

        return true;
    }
}
