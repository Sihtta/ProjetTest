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
        $mail->Password = 'fijw fpna kbcu pftt';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('matthis.pourcelot@gmail.com', 'Mon Portfolio');
        $mail->addAddress('matthis.pourcelot@gmail.com', 'Matthis');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <h3>Vous avez reçu un message :</h3>
            <p><strong>Nom :</strong> $name</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Téléphone :</strong> $phone</p>
            <p><strong>Message :</strong><br>$message</p>
        ";
        $mail->AltBody = "Nom : $name\nEmail : $email\nMessage : $message";

        $mail->send();
        header("Location: index.php?success=true");
        exit;
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
    }
}
