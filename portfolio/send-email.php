<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'matthis.pourcelot@gmail.com';
        $mail->Password = 'fijw fpna kbcu pftt'; // Le mot de passe d'application généré
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuration de l'expéditeur et du destinataire
        $mail->setFrom('matthis.pourcelot@gmail.com', 'Mon Portfolio');
        $mail->addAddress('matthis.pourcelot@gmail.com', 'Matthis');

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <h3>Vous avez reçu un message :</h3>
            <p><strong>Nom :</strong> $name</p>
            <p><strong>Email :</strong> $phone</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Message :</strong><br>$message</p>
        ";
        $mail->AltBody = "Nom : $name\nEmail : $email\nMessage : $message";

        // Envoi
        $mail->send();
        echo "Message envoyé avec succès !";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
    }
}
