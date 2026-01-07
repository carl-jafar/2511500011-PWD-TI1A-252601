<?php
session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

# 1. Cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('index.php');
}

# 2. LOGIKA UNTUK FORM BIODATA
if (isset($_POST['btnBiodata'])) {
    $nim      = bersihkan($_POST['txtNim'] ?? '');
    $nama_l   = bersihkan($_POST['txtNmLengkap'] ?? '');
    $tempat   = bersihkan($_POST['txtT4Lhr'] ?? '');
    $tanggal  = bersihkan($_POST['txtTglLhr'] ?? '');
    $hobi     = bersihkan($_POST['txtHobi'] ?? '');
    $pasangan = bersihkan($_POST['txtPasangan'] ?? '');
    $kerja    = bersihkan($_POST['txtKerja'] ?? '');
    $ortu     = bersihkan($_POST['txtNmOrtu'] ?? '');
    $kakak    = bersihkan($_POST['txtNmKakak'] ?? '');
    $adik     = bersihkan($_POST['txtNmAdik'] ?? '');

    $sqlBio = "INSERT INTO tbl_about_me (nim, nama_lengkap, tempat_lahir, tanggal_lahir, hobi, pasangan, pekerjaan, nama_ortu, nama_kakak, nama_adik) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sqlBio);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $nim, $nama_l, $tempat, $tanggal, $hobi, $pasangan, $kerja, $ortu, $kakak, $adik);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash_sukses'] = 'Biodata berhasil diperbarui!';
    } else {
        $_SESSION['flash_error'] = 'Gagal menyimpan biodata ke database.';
    }
    
    mysqli_stmt_close($stmt);
    redirect_ke('index.php#about');
}

# 3. LOGIKA UNTUK FORM KONTAK
if (isset($_POST['btnKontak'])) {
    $nama    = bersihkan($_POST['txtNama']   ?? '');
    $email   = bersihkan($_POST['txtEmail']  ?? '');
    $pesan   = bersihkan($_POST['txtPesan']  ?? '');
    $captcha = bersihkan($_POST['txtCaptcha'] ?? '');

    # Validasi
    $errors = [];
    if ($nama === '') $errors[] = 'Nama wajib diisi.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if (mb_strlen($pesan) < 10) $errors[] = 'Pesan minimal 10 karakter.';
    if ($captcha !== "5") $errors[] = 'Jawaban captcha salah.';

    if (!empty($errors)) {
        $_SESSION['old'] = ['nama' => $nama, 'email' => $email, 'pesan' => $pesan];
        $_SESSION['flash_error'] = implode('<br>', $errors);
        redirect_ke('index.php#contact');
    }

    # Insert ke tbl_tamu
    $sql = "INSERT INTO tbl_tamu (cnama, cemail, cpesan) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $pesan);

    if (mysqli_stmt_execute($stmt)) {
        unset($_SESSION['old']);
        $_SESSION['flash_sukses'] = 'Pesan Anda sudah tersimpan.';
    } else {
        $_SESSION['flash_error'] = 'Gagal menyimpan pesan.';
    }
    
    mysqli_stmt_close($stmt);
    redirect_ke('index.php#contact');
}