<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);?>


<?php

include('connection.php');


$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';


$status="pending";


$sql="INSERT INTO form(name,email,subject,message,status)
VALUES(?,?,?,?,?)";


$stmt=mysqli_prepare($connection,$sql);


mysqli_stmt_bind_param(
$stmt,
"sssss",
$name,
$email,
$subject,
$message,
$status
);


if(mysqli_stmt_execute($stmt)){


echo "Message Sent";


}
else{


echo "Database Error";


}


?>