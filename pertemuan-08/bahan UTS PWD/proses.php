<?php
session_start();
$sesnama = $_POST["txtNama"];
$sesemail = $_POST["txtEmail"];
$sespesan = $_POST["txtPesan"];
$_SESSION["sesnama"] = $sesnama;
$_SESSION["sesemail"] = $sesemail;
$_SESSION["sespesan"] = $sespesan;
$$_SESSION["nim"]         = $_POST["txtNim"] ?? '';
$_SESSION["namaLengkap"] = $_POST["txtNmLengkap"] ?? '';
$_SESSION["lahir"]       = $_POST["txtlahir"] ?? '';
$_SESSION["tglLahir"]    = $_POST["txttgllahir"] ?? '';
$_SESSION["hobi"]        = $_POST["txthobi"] ?? '';
$_SESSION["pasangan"]    = $_POST["txtpasangan"] ?? '';
$_SESSION["pekerjaan"]   = $_POST["txtpekerjaan"] ?? '';
$_SESSION["ortu"]        = $_POST["txtOrtu"] ?? '';
$_SESSION["kakak"]       = $_POST["txtKakak"] ?? '';
$_SESSION["adik"]        = $_POST["txtAdik"] ?? '';
header("location: index.php");
?>