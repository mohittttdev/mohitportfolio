<?php

date_default_timezone_set('Asia/Kolkata');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/vendor/autoload.php';

// .env file load karo
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$email = trim($_POST['email'] ?? '');



if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

    exit("invalid");

}



try{


    $mail = new PHPMailer(true);



    // SMTP

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;


  $mail->Username = $_ENV['EMAIL_USER'];
$mail->Password = $_ENV['EMAIL_PASS'];

    $mail->SMTPSecure =
    PHPMailer::ENCRYPTION_STARTTLS;


    $mail->Port = 587;



    // Sender
$mail->setFrom(
    $_ENV['EMAIL_USER'],
    'Newsletter System'
);

$mail->addAddress(
    $_ENV['EMAIL_USER']
);


    $mail->isHTML(true);



    $mail->Subject =
    'Newsletter Unsubscribe Alert 🚨';



    $mail->Body = "

    <div style='font-family:Arial;padding:20px'>


        <h2>
        Newsletter Unsubscribe Alert 🚨
        </h2>


        <p>
        A user has unsubscribed from your newsletter.
        </p>


        <p>
        <strong>User Email:</strong>
        $email
        </p>


        <p>
        <strong>Status:</strong>
        Inactive
        </p>


        <p>
        <strong>Date:</strong>
        ".date('d M Y h:i A')."
        </p>


    </div>

    ";



    $mail->send();


    echo "success";



}
catch(Exception $e){


    error_log(
        "Unsubscribe Mail Error: "
        .$mail->ErrorInfo
    );


    echo "mail_error";


}


?>