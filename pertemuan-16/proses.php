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
    $nim      = bersihkan($_POST['txtkddsn'] ?? '');
    $nama     = bersihkan($_POST['txtNm'] ?? '');
    $tempat   = bersihkan($_POST['txtAlamat'] ?? '');
    $tanggal  = bersihkan($_POST['txtTanggal'] ?? '');
    $hobi     = bersihkan($_POST['txtjja'] ?? '');
    $pasangan = bersihkan($_POST['txthomebase'] ?? '');
    $kerja    = bersihkan($_POST['txtnomor'] ?? '');
    $ortu     = bersihkan($_POST['txtpasangan'] ?? '');
    $kakak    = bersihkan($_POST['txtanak'] ?? '');
    $adik     = bersihkan($_POST['txtilmu'] ?? '');

    // 2. VALIDASI
    $errors = [];
    if ($nim === '') $errors[] = 'kode dosen wajib diisi.';
    if ($nama === '') $errors[] = 'Nama lengkap wajib diisi.';

    if (!empty($errors)) {
        $_SESSION['flash_error'] = implode('<br>', $errors);
        redirect_ke('index.php#biodata');
        exit;
    }

    // 3. INSERT KE TABEL BARU 
    $sql = "INSERT INTO tbl_biodata_dsn (kode_dosen, nama_dosen, alamat_rumah, tanggal_jadi_dosen, jja_dosen, homebase_prodi, nomor_hp, nama_pasangan, nama_anak, bidang_ilmu_dosen) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $kddsn, $nama, $alamat, $tanggal, $jja, $homebase, $nomor, $pasangan, $anak, $ilmu);

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