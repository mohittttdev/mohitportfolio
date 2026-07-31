<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// ==========================
// Contact Form Code
// ==========================

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mohitttt009@gmail.com';
    $mail->Password = 'vzqx qhii sssb ogza';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('mohitttt009@gmail.com', 'Portfolio Contact');
    $mail->addAddress('mohitttt009@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = $subject;

    $mail->Body = "
        Name: $name <br>
        Email: $email <br>
        Message: $message
    ";

    $mail->send();

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}


// ==========================
// Newsletter Welcome Email
// ==========================

function sendWelcomeMail($email)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mohitttt009@gmail.com';
        $mail->Password = 'vzqx qhii sssb ogza';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('mohitttt009@gmail.com', 'Mohit Portfolio');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Welcome to My Portfolio 🚀";

        $mail->Body = "
            <h2>Welcome!</h2>
            <p>Thank you for subscribing to my portfolio.</p>
            <p>You'll receive updates whenever I add new projects or improve my website.</p>
            <br>
            <a href='https://yourwebsite.com'>Visit Portfolio</a>
        ";

        $mail->send();

    } catch (Exception $e) {
        return false;
    }

    return true;
}