<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer-master/src/Exception.php';
require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';

function EnvoieMailFormulaire($infos) {
    $mail = new PHPMailer(true);

    try {
        // Debug
        $mail->SMTPDebug = 0; // 0 = off, 2 = verbose pour développement
        $mail->Debugoutput = function($str, $level) {
            error_log("PHPMailer [$level]: $str");
        };

        // Config SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'ssl0.ovh.net';
        $mail->Port = 465; // ou 587 si STARTTLS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // pour 465
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@alex2.dev';
        $mail->Password = 'Alex.2005'; // ⚠️ change-moi si compromis
        $mail->setFrom('contact@alex2.dev', 'Formulaire Web');
        $mail->addAddress('contact.alex2.dev@gmail.com');

        
        if (!empty($infos['email'])) {
            $mail->addReplyTo($infos['email'], trim($infos['prenom'] . ' ' . $infos['nom']));
        }

        // Contenu du mail
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $infos['sujet'] ?: 'Nouveau message depuis le formulaire';

        // Version HTML
        $htmlBody = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #51845C 0%, #30b8c6 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            color: #ffffff;
            font-size: 28px;
            font-weight: 900;
            margin: 0;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
        }
        .title {
            color: #1f2020;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        .subtitle {
            color: #666;
            font-size: 14px;
            margin: 0 0 30px 0;
        }
        .info-card {
            background-color: #f8f9fa;
            border-left: 4px solid #51845C;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-start;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            color: #51845C;
            font-weight: 600;
            font-size: 13px;
            min-width: 120px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            color: #1f2020;
            font-size: 15px;
            flex: 1;
        }
        .message-card {
            background-color: #ffffff;
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            padding: 25px;
            margin-top: 20px;
        }
        .message-label {
            color: #30b8c6;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .message-content {
            color: #1f2020;
            font-size: 15px;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #1f2020;
            color: #e8e8e8;
            padding: 30px;
            text-align: center;
            font-size: 13px;
        }
        .footer-logo {
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .footer-text {
            color: #999;
            margin: 5px 0;
        }
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e8e8e8, transparent);
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">&lt;Alex²/&gt;</div>
        </div>

        <!-- Content -->
        <div class="content">
            <h1 class="title">Nouveau message reçu</h1>
            <p class="subtitle">Un client potentiel vous a contacté via le formulaire</p>

            <div class="divider"></div>

            <!-- Informations du contact -->
            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    <span class="info-value">{$infos['nom']}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Prénom</span>
                    <span class="info-value">{$infos['prenom']}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value"><a href="mailto:{$infos['email']}" style="color: #30b8c6; text-decoration: none;">{$infos['email']}</a></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value"><a href="tel:{$infos['telephone']}" style="color: #30b8c6; text-decoration: none;">{$infos['telephone']}</a></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Société</span>
                    <span class="info-value">{$infos['entreprise']}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Budget</span>
                    <span class="info-value">{$infos['budget']}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Objet</span>
                    <span class="info-value">{$infos['sujet']}</span>
                </div>
            </div>

            <!-- Message -->
            <div class="message-card">
                <div class="message-label">Message</div>
                <div class="message-content">{$infos['message']}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">&lt;Alex²/&gt;</div>
            <p class="footer-text">Agence web à Tarbes et Lourdes (65)</p>
            <p class="footer-text">Ce message a été envoyé depuis alex2.dev</p>
        </div>
    </div>
</body>
</html>
HTML;

        // Version texte brut (fallback)
        $textBody = <<<TEXT
Nouveau message depuis le formulaire de contact :

Nom        : {$infos['nom']}
Prénom     : {$infos['prenom']}
Email      : {$infos['email']}
Téléphone  : {$infos['telephone']}
Société    : {$infos['entreprise']}
Budget     : {$infos['budget']}
Objet      : {$infos['sujet']}

Message :
{$infos['message']}

---
<Alex²/>
Agence web à Tarbes et Lourdes (65)
TEXT;

        $mail->Body = $htmlBody;
        $mail->AltBody = $textBody;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Erreur PHPMailer : " . $mail->ErrorInfo);
        return false;
    }
}
?>
