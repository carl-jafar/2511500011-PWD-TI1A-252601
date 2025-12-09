<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_pwd2025";

$conn = my_sqliconnect($host, $user, $pass, $db);

if (!$conn) {
    die("koneksi gagal:" . mysqli_connect_error());
}
?>