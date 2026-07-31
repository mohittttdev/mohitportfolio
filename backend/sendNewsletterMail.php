<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendWelcomeMail($email)
{
    $mail = new PHPMailer(true);

    try {

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mohitttt009@gmail.com';
        $mail->Password = 'vzqx qhii sssb ogza'; // अपना Gmail App Password डालो
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender
        $mail->setFrom('mohitttt009@gmail.com', 'Mohit Portfolio');

        // Receiver
        $mail->addAddress($email);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Mohit Portfolio 🚀';

        $mail->Body = "
        <div style='font-family:Arial,sans-serif;padding:20px'>
            <h2>Welcome! 👋</h2>

            <p>Thank you for subscribing to my portfolio website.</p>

            <p>
                You'll receive notifications whenever I publish
                new projects, blogs or major website updates.
            </p>

            <br>

            <a href='https://yourwebsite.com'
               style='background:#0d6efd;
                      color:#fff;
                      padding:12px 20px;
                      text-decoration:none;
                      border-radius:5px;'>
                Visit Portfolio
            </a>

            <br><br>

            <p>Thanks ❤️</p>
            <p><strong>Mohit Sharma</strong></p>
        </div>
        ";

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;
    }
}