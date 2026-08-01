<?php

date_default_timezone_set('Asia/Kolkata');

include('connection.php');


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("error");
}


$email = trim($_POST['email'] ?? '');


// Validation

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("invalid");
}



// Check User Status

$check = $conn->prepare(
    "SELECT id,status FROM newslatter WHERE email=?"
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



$user = $result->fetch_assoc();



// Already Unsubscribed

if($user['status'] == "inactive"){


    // Cookie remove

    setcookie(
        "newsletter_token",
        "",
        time() - 3600,
        "/"
    );


    echo "already_unsubscribed";

    exit;

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
        [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ]
    );



    echo "success";



}else{


    echo "error";


}



$update->close();

$check->close();

$conn->close();


?>