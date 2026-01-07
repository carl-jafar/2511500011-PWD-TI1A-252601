<?php
session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('index.php');
}

// ==========================================================
// LOGIKA UNTUK FORM BIODATA
// ==========================================================
if (isset($_POST['btnBiodata'])) {
    // 1. SANITASI (
    $nim      = bersihkan($_POST['txtNim'] ?? '');
    $nama     = bersihkan($_POST['txtNmLengkap'] ?? '');
    $tempat   = bersihkan($_POST['txtT4Lhr'] ?? '');
    $tanggal  = bersihkan($_POST['txtTglLhr'] ?? '');
    $hobi     = bersihkan($_POST['txtHobi'] ?? '');
    $pasangan = bersihkan($_POST['txtPasangan'] ?? '');
    $kerja    = bersihkan($_POST['txtKerja'] ?? '');
    $ortu     = bersihkan($_POST['txtNmOrtu'] ?? '');
    $kakak    = bersihkan($_POST['txtNmKakak'] ?? '');
    $adik     = bersihkan($_POST['txtNmAdik'] ?? '');

    // 2. VALIDASI
    $errors = [];
    if ($nim === '') $errors[] = 'NIM wajib diisi.';
    if ($nama === '') $errors[] = 'Nama lengkap wajib diisi.';

    if (!empty($errors)) {
        $_SESSION['flash_error'] = implode('<br>', $errors);
        redirect_ke('index.php#biodata');
        exit;
    }

    // 3. INSERT KE TABEL BARU 
    $sql = "INSERT INTO tbl_biodata_mhs (nim, nama_lengkap, tempat_lahir, tanggal_lahir, hobi, pasangan, pekerjaan, nama_ortu, nama_kakak, nama_adik) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $nim, $nama, $tempat, $tanggal, $hobi, $pasangan, $kerja, $ortu, $kakak, $adik);

    if (mysqli_stmt_execute($stmt)) {
        // 4. KONSEP PRG 
        $_SESSION['flash_sukses'] = 'Data biodata berhasil disimpan.';
        redirect_ke('read.php'); // Lanjut ke file pembaca 
    } else {
        $_SESSION['flash_error'] = 'Gagal menyimpan data ke database.';
        redirect_ke('index.php#biodata');
    }
    mysqli_stmt_close($stmt);
    exit; // Menghentikan script agar tidak lanjut ke logika kontak
}

// ==========================================================
// LOGIKA UNTUK FORM KONTAK 
// ==========================================================
if (isset($_POST['btnKontak'])) {
    $nama    = bersihkan($_POST['txtNama'] ?? '');
    $email   = bersihkan($_POST['txtEmail'] ?? '');
    $pesan   = bersihkan($_POST['txtPesan'] ?? '');
    $captcha = bersihkan($_POST['txtCaptcha'] ?? '');

    // ... (Gunakan kode validasi kontak Anda yang sudah ada di sini) ...

    $sql = "INSERT INTO tbl_tamu (cnama, cemail, cpesan) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $pesan);

    if (mysqli_stmt_execute($stmt)) {
        unset($_SESSION['old']);
        $_SESSION['flash_sukses'] = 'Terima kasih, pesan tersimpan.';
    }
    redirect_ke('index.php#contact');
    exit;
}