<?php

include('connection.php');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("error");
}


$email = trim($_POST['email'] ?? '');


// Email Validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("invalid");
}


// Check User Exists
$check = $conn->prepare(
    "SELECT id FROM newslatter WHERE email = ?"
);

$check->bind_param("s", $email);

$check->execute();

$result = $check->get_result();


if ($result->num_rows === 0) {

    exit("not_found");

}


// Update Status

$update = $conn->prepare(
    "UPDATE newslatter 
     SET status='inactive'
     WHERE email=?"
);


$update->bind_param(
    "s",
    $email
);


if ($update->execute()) {

    echo "success";

} else {

    echo "error";

}


$update->close();
$check->close();
$conn->close();

exit;

?>