<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "portfolio"   // Apna actual database name
);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>