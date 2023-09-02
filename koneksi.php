<?php
$host="localhost";
$user="root";
$pass="";
$db="toko_online";

$con = mysqli_connect("$host","$user","$pass","$db");
if(mysqli_connect_errno()){
    echo "failed to connect to mysqli:" . mysqli_connect_error();
    exit();
}
?>