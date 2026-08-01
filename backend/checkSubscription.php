<?php

include('connection.php');


$email = trim($_POST['email'] ?? '');


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo "invalid";
    exit;

}


$stmt = $conn->prepare(
    "SELECT status FROM newslatter WHERE email=?"
);


$stmt->bind_param("s",$email);


$stmt->execute();


$result = $stmt->get_result();



if($result->num_rows > 0){


    $data = $result->fetch_assoc();


    echo $data['status'];


}else{


    echo "none";


}



$stmt->close();
$conn->close();

?>