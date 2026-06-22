<?php
$connection = mysqli_connect("localhost" , "root" , "" , "portfolio");

if($connection){
    echo 'data is connected ';
}
else{
    die("database is error");
}





?>