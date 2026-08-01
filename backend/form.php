<?php

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        exit("error");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("invalid");
    }

    $status = "Unread";

    $stmt = $conn->prepare("INSERT INTO form (name, email, subject, message, status)
                            VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sssss",
        $name,
        $email,
        $subject,
        $message,
        $status
    );

    if ($stmt->execute()) {

        echo "success";

    } else {

        echo "error";

    }

    $stmt->close();
    $conn->close();
    exit;
}

echo "error";
?>