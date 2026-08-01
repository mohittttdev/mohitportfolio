<?php

date_default_timezone_set('Asia/Kolkata');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/vendor/autoload.php';



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


    $mail->Username =
    'mohitttt009@gmail.com';


    $mail->Password =
    'vzqx qhii sssb ogza';


    $mail->SMTPSecure =
    PHPMailer::ENCRYPTION_STARTTLS;


    $mail->Port = 587;



    // Sender

    $mail->setFrom(
        'mohitttt009@gmail.com',
        'Newsletter System'
    );


    // Only admin mail

    $mail->addAddress(
        'mohitttt009@gmail.com'
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