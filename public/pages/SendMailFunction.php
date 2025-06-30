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
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact.alex2.dev@gmail.com';
        $mail->Password = 'ntlddwqckndygfyy'; // ⚠️ change-moi si compromis
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur et destinataires
        $mail->setFrom('contact.alex2.dev@gmail.com', 'Formulaire Web');
        $mail->addAddress('contact.alex2.dev@gmail.com', 'Contact Alex²');
        
        if (!empty($infos['email'])) {
            $mail->addReplyTo($infos['email'], trim($infos['prenom'] . ' ' . $infos['nom']));
        }

        // Contenu du mail
        $mail->isHTML(false); // en texte brut
        $mail->Subject = $infos['sujet'] ?: 'Message depuis le formulaire';

        $contenu = <<<EOT
Nouveau message depuis le formulaire de contact :

Nom        : {$infos['nom']}
Prénom     : {$infos['prenom']}
Email      : {$infos['email']}
Téléphone  : {$infos['telephone']}
Société    : {$infos['entreprise']}
Objet      : {$infos['sujet']}

Message :
{$infos['message']}
EOT;

        $mail->Body = $contenu;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Erreur PHPMailer : " . $mail->ErrorInfo);
        return false;
    }
}
?>
