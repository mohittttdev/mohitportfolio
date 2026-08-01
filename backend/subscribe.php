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
    "SELECT id, status FROM newslatter WHERE email = ?"
);

$check->bind_param("s", $email);

$check->execute();

$result = $check->get_result();


if ($result->num_rows > 0) {


    $user = $result->fetch_assoc();


    // Already active
    if ($user['status'] === "active") {

        exit("exists");

    }


    // Reactivate after unsubscribe
    $update = $conn->prepare(
        "UPDATE newslatter 
         SET status='active',
         subscribe_date=NOW()
         WHERE email=?"
    );


    $update->bind_param("s",$email);


    if($update->execute()){

        echo "success";

    }else{

        echo "error";

    }


    $update->close();


}

else {


    // New Subscriber

    $token = bin2hex(random_bytes(16));


    $stmt = $conn->prepare(
        "INSERT INTO newslatter 
        (email,status,unsubscribe_token,subscribe_date)
        VALUES (?, 'active', ?, NOW())"
    );


    $stmt->bind_param(
        "ss",
        $email,
        $token
    );


    if($stmt->execute()){

        echo "success";

    }else{

        echo "error";

    }


    $stmt->close();

}


$check->close();
$conn->close();

exit;

?>