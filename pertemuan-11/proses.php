<?php 
session_start(); 
if (isset($_POST["txtNim"])) {
    $arrBiodata = [
        "nim" => $_POST["txtNim"] ?? "",
        "nama" => $_POST["txtNmLengkap"] ?? "",
        "tempat" => $_POST["txtT4Lhr"] ?? "",
        "tanggal" => $_POST["txtTglLhr"] ?? "",
        "hobi" => $_POST["txtHobi"] ?? "",
        "pasangan" => $_POST["txtPasangan"] ?? "",
        "pekerjaan" => $_POST["txtKerja"] ?? "",
        "ortu" => $_POST["txtNmOrtu"] ?? "",
        "kakak" => $_POST["txtNmKakak"] ?? "",
        "adik" => $_POST["txtNmAdik"] ?? ""
    ];
    $_SESSION["biodata"] = $arrBiodata;
    header("Location: index.php#about");
    exit();
} elseif (isset($_POST["txtNama"])) {
    $arrContact = [ 
        "nama" => $_POST["txtNama"] ?? "", 
        "email" => $_POST["txtEmail"] ?? "", 
        "pesan" => $_POST["txtPesan"] ?? "" 
    ]; 
    $_SESSION["contact"][] = $arrContact;     
    header("Location: index.php#contact");
    exit();
}
header("Location: index.php");
exit();
?>