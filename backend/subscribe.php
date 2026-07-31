<?php

include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);

    // Email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("invalid");
    }

    // Check Duplicate Email
    $check = $conn->prepare("SELECT id FROM newslatter WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        die("exists");
    }

    // Generate Token
    $token = bin2hex(random_bytes(16));

    // Insert Email
    $stmt = $conn->prepare("INSERT INTO newslatter (email, status, unsubscribe_token) VALUES (?, 'active', ?)");
    $stmt->bind_param("ss", $email, $token);

   if ($stmt->execute()) {

    require 'sendNewsletterMail.php';

if (sendWelcomeMail($email)) {
    echo "success";
} else {
    echo "mail_error";
}
} else {

    echo "error";
}
    $stmt->close();
    $check->close();
    $conn->close();
}
?>