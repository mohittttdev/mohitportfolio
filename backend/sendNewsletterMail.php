

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit;
}

$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("invalid");
}

$mail = new PHPMailer(true);

try {

    // SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mohitttt009@gmail.com';
    $mail->Password = 'vzqx qhii sssb ogza'; // <-- App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // SMTP ko thoda optimize karo
    $mail->Timeout = 10;
    $mail->SMTPKeepAlive = false;

    // Sender
    $mail->setFrom('mohitttt009@gmail.com', 'Mohit Portfolio');

    // Receiver
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Welcome to Mohit Portfolio Website';

    $mail->Body = "
    <div style='font-family:Arial,sans-serif;padding:20px'>
        <h2>Welcome! </h2>

        <p>Thank you for subscribing to my portfolio website.</p>

        <p>
            You'll receive notifications whenever I publish
            new projects, blogs or major website updates.
        </p>

        <br>

        <a href='https://yourwebsite.com'
           style='background:#0d6efd;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;'>
            Visit Portfolio
        </a>

        <br><br>

        <p>Thanks </p>
        <p><strong>Mohit Sharma</strong></p>
    </div>";

    $mail->send();

    echo "success";

} catch (Exception $e) {

    echo "error";

}