<?php
include('connection.php');

if(isset($_POST['submit'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Basic validation
    if(empty($name) || empty($email) || empty($message)){
        echo "All required fields must be filled";
        exit;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email";
        exit;
    }

    // Insert query
    $sql = "INSERT INTO form (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($connection);

    if(mysqli_stmt_prepare($stmt, $sql)){

        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);

        if(mysqli_stmt_execute($stmt)){
            echo "Message Sent Successfully";
        } else {
            echo "Database Error";
        }

    }

    mysqli_stmt_close($stmt);
}
?>