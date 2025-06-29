<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

function EnvoieMailFormulaire($infos) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'error_log';

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact.alex2.dev@gmail.com';
        $mail->Password = 'ntlddwqckndygfyy';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('contact.alex2.dev@gmail.com', 'Formulaire Web');
        $mail->addReplyTo($infos['email'], trim($infos['prenom'] . ' ' . $infos['nom']));
        $mail->addAddress('contact.alex2.dev@gmail.com');

        $mail->isHTML(false);
        $mail->Subject = $infos['sujet'] ?: '(Sans sujet)';

        $contenu = "Nouveau message depuis le formulaire :\n\n";
        $contenu .= "Nom : " . $infos['nom'] . "\n";
        $contenu .= "Prénom : " . $infos['prenom'] . "\n";
        $contenu .= "Email : " . $infos['email'] . "\n";
        $contenu .= "Téléphone : " . $infos['telephone'] . "\n";
        $contenu .= "Entreprise : " . $infos['entreprise'] . "\n";
        $contenu .= "Message :\n" . $infos['message'];

        $mail->Body = $contenu;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur PHPMailer : " . $mail->ErrorInfo);
        return false;
    }
}
?>
