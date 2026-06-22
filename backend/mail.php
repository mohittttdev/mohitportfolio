<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';



$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

$mail = new PHPMailer(true);


try{


$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'mohitttt009@gmail.com';
$mail->Password = 'vzqx qhii sssb ogza';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;


$mail->setFrom(
"mohitttt009@gmail.com",
"Portfolio Contact"
);


$mail->addAddress(
"mohitttt009@gmail.com"
);


$mail->isHTML(true);

$mail->Subject=$subject;


$mail->Body="
Name: $name <br>
Email: $email <br>
Message: $message
";


$mail->send();



}

catch(Exception $e){
    echo "Mailer Error: " . $mail->ErrorInfo;
}


?>