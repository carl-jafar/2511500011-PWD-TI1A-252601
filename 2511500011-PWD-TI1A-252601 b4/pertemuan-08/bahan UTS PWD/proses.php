<?php
session_start();

$_SESSION["txtNim"]       = $_POST["txtNim"] ?? '';
$_SESSION["txtNmLengkap"] = $_POST["txtNmLengkap"] ?? '';
$_SESSION["txtlahir"]     = $_POST["txtlahir"] ?? '';
$_SESSION["txttgllahir"]  = $_POST["txttgllahir"] ?? '';
$_SESSION["txthobi"]      = $_POST["txthobi"] ?? '';
$_SESSION["txtpasangan"]  = $_POST["txtpasangan"] ?? '';
$_SESSION["txtpekerjaan"] = $_POST["txtpekerjaan"] ?? '';
$_SESSION["txtOrtu"]      = $_POST["txtOrtu"] ?? '';
$_SESSION["txtKakak"]     = $_POST["txtKakak"] ?? '';
$_SESSION["txtAdik"]      = $_POST["txtAdik"] ?? '';
$_SESSION["sesnama"]  = $_POST["txtNama"] ?? '';
$_SESSION["sesemail"] = $_POST["txtEmail"] ?? '';
$_SESSION["sespesan"] = $_POST["txtPesan"] ?? '';

foreach ($_POST as $key => $value) {
  $_SESSION[$key] = $value;
}

header("Location: index.php");
exit;
?>
