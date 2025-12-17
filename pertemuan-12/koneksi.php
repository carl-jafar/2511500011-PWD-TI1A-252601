<?php 
$host = "localhost";
$user = "root";
$pass = "root";
$db = "db_pwd2025";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("koneksi gagal:" . mysqli_connect_error());
}
?>