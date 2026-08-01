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



// Check Existing User

$check = $conn->prepare(
    "SELECT id,status,unsubscribe_token 
     FROM newslatter 
     WHERE email=?"
);


$check->bind_param(
    "s",
    $email
);


$check->execute();


$result = $check->get_result();



if($result->num_rows > 0){


    $user = $result->fetch_assoc();



    // Already Active

    if($user['status']=="active"){


        setcookie(
            "newsletter_token",
            $user['unsubscribe_token'],
            time() + (86400 * 365),
            "/"
        );


        echo "exists";

        exit;

    }


    // Re Subscribe

    else{


        $update = $conn->prepare(
            "UPDATE newslatter
             SET status='active'
             WHERE email=?"
        );


        $update->bind_param(
            "s",
            $email
        );


        $update->execute();



        setcookie(
            "newsletter_token",
            $user['unsubscribe_token'],
            time() + (86400 * 365),
            "/"
        );


        echo "success";

        exit;

    }



}



// New Subscriber


$token = bin2hex(random_bytes(32));



$stmt = $conn->prepare(

"INSERT INTO newslatter
(email,status,unsubscribe_token)

VALUES(?, 'active', ?)"

);



$stmt->bind_param(

"ss",

$email,

$token

);



if($stmt->execute()){



    // Save Cookie

    setcookie(
        "newsletter_token",
        $token,
        time() + (86400 * 365),
        "/"
    );



    echo "success";



}else{


    echo "error";


}



$stmt->close();
$check->close();
$conn->close();


?>