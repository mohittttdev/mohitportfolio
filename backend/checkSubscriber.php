<?php

include('connection.php');

header('Content-Type: application/json');



$token = $_COOKIE['newsletter_token'] ?? '';



// Cookie nahi hai

if(empty($token)){


    echo json_encode([
        "status" => "none"
    ]);


    exit;

}




// Token Check

$stmt = $conn->prepare(
    "SELECT email,status 
     FROM newslatter 
     WHERE unsubscribe_token=?"
);



$stmt->bind_param(
    "s",
    $token
);



$stmt->execute();



$result = $stmt->get_result();




if($result->num_rows > 0){



    $user = $result->fetch_assoc();



    echo json_encode([

        "status" => $user['status'],

        "email" => $user['email']

    ]);



}else{



    echo json_encode([

        "status" => "none"

    ]);



}



$stmt->close();

$conn->close();


?>