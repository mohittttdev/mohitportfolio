<?php

$connection = mysqli_connect(
    "sql109.infinityfree.com",   // MySQL Hostname
    "if0_42237598",              // DB Username
    "5dhuAJkDbosjFI6",          // DB Password
    "if0_42237598_portfolio"     // DB Name
);

if(!$connection){
    die("Connection Failed: " . mysqli_connect_error());
}

echo "Database Connected";
?>