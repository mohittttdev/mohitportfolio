<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Please fill all fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid Email Address.");
    }

    $status = "Unread";

    $sql = "INSERT INTO form (name, email, subject, message, status)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $name,
            $email,
            $subject,
            $message,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {
            echo "Message Sent Successfully";
        } else {
            echo "Database Error";
        }

        mysqli_stmt_close($stmt);

    } else {

        echo "Query Failed";

    }

    mysqli_close($connection);

}
?>