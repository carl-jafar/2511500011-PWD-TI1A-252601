<?php 
session_start();
  $sesname = $_SESSION["nama"] = $_POST["txtNama"]
  $sesemail = $_SESSION["email"] = $_POST["txtEmail"]
  $sespesan = $_SESSION["pesan"]= $_POST["txtPesan"]
  echo $_SESSIONl.["nama"].$_SESSION["email"].$_SESSION["pesan"]  
  header(header: "Location: get.php")
?>