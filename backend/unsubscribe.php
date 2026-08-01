<?php

date_default_timezone_set('Asia/Kolkata');

include('connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("error");
}


$email = trim($_POST['email'] ?? '');


// Validation

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("invalid");
}



// Check User

$check = $conn->prepare(
    "SELECT id FROM newslatter WHERE email=?"
);

$check->bind_param(
    "s",
    $email
);

$check->execute();

$result = $check->get_result();



if($result->num_rows == 0){

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



if($update->execute()){



    // Remove Cookie

    setcookie(
        "newsletter_token",
        "",
        time() - 3600,
        "/"
    );



    // ==========================
    // ADMIN EMAIL ALERT
    // ==========================


    try {


        $mail = new PHPMailer(true);


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



        $mail->setFrom(
            'mohitttt009@gmail.com',
            'Newsletter System'
        );


        // Only Mohit gets mail

        $mail->addAddress(
            'mohitttt009@gmail.com'
        );



        $mail->isHTML(true);



        $mail->Subject =
        'Newsletter Unsubscribe Alert';



        $mail->Body = "

        <div style='font-family:Arial;padding:20px'>

            <h2>
            Newsletter Unsubscribe Alert 🚨
            </h2>


            <p>
            A user has unsubscribed from your newsletter.
            </p>


            <p>
            <strong>Email:</strong>
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



    } catch(Exception $e){


        error_log(
            "Unsubscribe Mail Error: "
            .$mail->ErrorInfo
        );


    }



    echo "success";



}else{


    echo "error";


}



$update->close();

$check->close();

$conn->close();


?>