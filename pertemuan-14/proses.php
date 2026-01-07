<?php
session_start();
require __DIR__ . './koneksi.php';
require_once __DIR__ . '/fungsi.php';

// Pastikan hanya akses via POST yang diizinkan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_ke('index.php');
}

// =================================================================
// LOGIKA 1: PROSES BIODATA MAHASISWA (Jika tombol dari form biodata dikirim)
// =================================================================
if (isset($_POST['txtNim'])) {
    // 1. Ambil dan bersihkan data
    $arrBiodata = [
        "nim"       => bersihkan($_POST["txtNim"] ?? ""),
        "nama"      => bersihkan($_POST["txtNmLengkap"] ?? ""),
        "tempat"    => bersihkan($_POST["txtT4Lhr"] ?? ""),
        "tanggal"   => bersihkan($_POST["txtTglLhr"] ?? ""),
        "hobi"      => bersihkan($_POST["txtHobi"] ?? ""),
        "pasangan"  => bersihkan($_POST["txtPasangan"] ?? ""),
        "pekerjaan" => bersihkan($_POST["txtKerja"] ?? ""),
        "ortu"      => bersihkan($_POST["txtNmOrtu"] ?? ""),
        "kakak"     => bersihkan($_POST["txtNmKakak"] ?? ""),
        "adik"      => bersihkan($_POST["txtNmAdik"] ?? "")
    ];

    // 2. Simpan ke Session (agar langsung tampil di section About)
    $_SESSION["biodata"] = $arrBiodata;

    // 3. Simpan ke Database (tbl_about_me)
    $sqlBio = "INSERT INTO tbl_biodata_mhs (nim, nama_lengkap, tempat_lahir, tanggal_lahir, hobi, pasangan, pekerjaan, nama_ortu, nama_kakak, nama_adik) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmtBio = mysqli_prepare($conn, $sqlBio);
    if ($stmtBio) {
        mysqli_stmt_bind_param($stmtBio, "ssssssssss", 
            $arrBiodata['nim'], $arrBiodata['nama'], $arrBiodata['tempat'], 
            $arrBiodata['tanggal'], $arrBiodata['hobi'], $arrBiodata['pasangan'], 
            $arrBiodata['pekerjaan'], $arrBiodata['ortu'], $arrBiodata['kakak'], $arrBiodata['adik']
        );
        
        if (mysqli_stmt_execute($stmtBio)) {
            $_SESSION['flash_sukses'] = 'Biodata berhasil disimpan ke Database!';
        } else {
            $_SESSION['flash_error'] = 'Gagal menyimpan biodata ke database.';
        }
        mysqli_stmt_close($stmtBio);
    }

    redirect_ke('index.php#about');
}

// =================================================================
// LOGIKA 2: PROSES KONTAK KAMI (Jika tombol dari form kontak dikirim)
// =================================================================
if (isset($_POST['txtNama'])) {
    $nama    = bersihkan($_POST['txtNama'] ?? '');
    $email   = bersihkan($_POST['txtEmail'] ?? '');
    $pesan   = bersihkan($_POST['txtPesan'] ?? '');
    $captcha = bersihkan($_POST['txtCaptcha'] ?? '');

    // Validasi Captcha & Input
    $errors = [];
    if (empty($nama)) $errors[] = 'Nama wajib diisi.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if (strlen($pesan) < 10) $errors[] = 'Pesan minimal 10 karakter.';
    if ($captcha !== "5") $errors[] = 'Jawaban captcha salah.';

    if (!empty($errors)) {
        $_SESSION['old'] = ['nama' => $nama, 'email' => $email, 'pesan' => $pesan];
        $_SESSION['flash_error'] = implode('<br>', $errors);
        redirect_ke('index.php#contact');
    }

    // Insert ke tbl_tamu
    $sqlTamu = "INSERT INTO tbl_biodata_mhs (cnama, cemail, cpesan) VALUES (?, ?, ?)";
    $stmtTamu = mysqli_prepare($conn, $sqlTamu);
    
    if ($stmtTamu) {
        mysqli_stmt_bind_param($stmtTamu, "sss", $nama, $email, $pesan);
        if (mysqli_stmt_execute($stmtTamu)) {
            unset($_SESSION['old']);
            $_SESSION['flash_sukses'] = 'Pesan kontak berhasil terkirim!';
        } else {
            $_SESSION['flash_error'] = 'Gagal mengirim pesan.';
        }
        mysqli_stmt_close($stmtTamu);
    }
    
    redirect_ke('index.php#contact');
}