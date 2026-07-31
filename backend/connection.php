<?php

$conn = mysqli_connect(
    "sql109.infinityfree.com",
    "if0_42237598_XXX",
    "5dhuAJkDbosjFI6",
    "if0_42237598"
);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>