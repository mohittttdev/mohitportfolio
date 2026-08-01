<?php

date_default_timezone_set('Asia/Kolkata');


$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "portfolio"
);


if (!$conn) {

    die("Connection Failed: " . mysqli_connect_error());

}


mysqli_set_charset($conn, "utf8");


// MySQL timezone set

mysqli_query(
    $conn,
    "SET time_zone = '+05:30'"
);

?>