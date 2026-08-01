<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

// ==========================
// Get Form Data
// ==========================

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// ==========================
// Validation
// ==========================

if (
    $name === '' ||
    $email === '' ||
    $subject === '' ||
    $message === ''
) {
    exit('error');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('invalid');
}

$mail = new PHPMailer(true);

try {

    // ==========================
    // SMTP Configuration
    // ==========================

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'mohitttt009@gmail.com';
    $mail->Password   = 'vzqx qhii sssb ogza';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Performance
    $mail->Timeout = 10;
    $mail->SMTPKeepAlive = false;

    // ==========================
    // Email
    // ==========================

    $mail->setFrom('mohitttt009@gmail.com', 'Mohit Portfolio');

    // Sirf tumhare Gmail par mail aayegi
    $mail->addAddress('mohitttt009@gmail.com');

    // Reply karte waqt user ko reply ho
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->Subject = '📩 New Contact Form: ' . $subject;

    $mail->Body = '
    <div style="font-family:Arial,sans-serif;max-width:700px;margin:auto;padding:20px;border:1px solid #ddd;border-radius:10px">

        <h2 style="color:#16a34a;">
            New Contact Form Submission
        </h2>

        <hr>

        <p><strong>Name:</strong> '
        . htmlspecialchars($name) .
        '</p>

        <p><strong>Email:</strong> '
        . htmlspecialchars($email) .
        '</p>

        <p><strong>Subject:</strong> '
        . htmlspecialchars($subject) .
        '</p>

        <p><strong>Message:</strong></p>

        <div style="
            background:#f8f8f8;
            padding:15px;
            border-radius:8px;
            white-space:pre-wrap;
        ">'
        . nl2br(htmlspecialchars($message)) .
        '</div>

        <br>

        <hr>

        <small>
            Sent automatically from your Portfolio Contact Form.
        </small>

    </div>';

    $mail->send();

    echo "success";

} catch (Exception $e) {

    // Server logs ke liye useful
    error_log('PHPMailer Error: ' . $mail->ErrorInfo);

    echo "error";
}