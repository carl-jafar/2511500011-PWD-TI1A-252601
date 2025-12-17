<?php
session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

// Validasi metode akses
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

// Validasi CID
$cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$cid) {
    $_SESSION['flash_error'] = 'CID Tidak Valid.';
    redirect_ke('read.php');
}

// Mengambil dan membersihkan input
// Perbaikan: "berishkan" menjadi "bersihkan"
$nama    = bersihkan($_POST['txtNamaEd'] ?? ''); 
$email   = bersihkan($_POST['txtEmailEd'] ?? '');
$pesan   = bersihkan($_POST['txtPesanEd'] ?? '');
$captcha = bersihkan($_POST['txtCaptcha'] ?? '');

$errors = []; // Array untuk menampung semua error

// Validasi Input
if ($nama === '') {
    $errors[] = 'Nama wajib diisi.';
} elseif (mb_strlen($nama) < 3) {
    $errors[] = 'Nama minimal 3 karakter.';
}

if ($email === '') {
    $errors[] = 'EMAIL wajib diisi.';
}

if ($pesan === '') {
    $errors[] = 'Pesan wajib diisi.';
} elseif (mb_strlen($pesan) < 10) {
    $errors[] = 'Pesan minimal 10 karakter.';
}

if ($captcha === '') {
    $errors[] = 'Pertanyaan wajib diisi.';
} elseif ($captcha !== "6") {
    $errors[] = 'Jawaban captcha salah.';
}

// Jika ada error, kembalikan ke halaman edit dengan data lama
if (!empty($errors)) {
    $_SESSION['old'] = [
        'nama'  => $nama,
        'email' => $email,
        'pesan' => $pesan
    ];
    
    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('edit.php?cid=' . (int)$cid);
}

/* Prepared statement untuk anti SQL injection.
Menyiapkan query UPDATE dengan prepared statement.
*/
$stmt = mysqli_prepare($conn, "UPDATE tbl_tamu 
                               SET cnama = ?, cemail = ?, cpesan = ? 
                               WHERE cid = ?");

if (!$stmt) {
    // Jika gagal prepare, kirim pesan error
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit.php?cid=' . (int)$cid);
}

// Bind parameter dan eksekusi (s = string, i = integer)
mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $pesan, $cid);

if (mysqli_stmt_execute($stmt)) { 
    // Jika berhasil, kosongkan data lama
    unset($_SESSION['old']);
    $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah diperbaharui.';
    redirect_ke('read.php'); // Kembali ke halaman tampil data
} else { 
    // Jika gagal, simpan kembali data lama untuk form
    $_SESSION['old'] = [
        'nama'  => $nama,
        'email' => $email,
        'pesan' => $pesan
    ];
    $_SESSION['flash_error'] = 'Data gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('edit.php?cid=' . (int)$cid);
}

// Tutup statement
mysqli_stmt_close($stmt);

// Pengaman terakhir jika semua proses terlewati
redirect_ke('edit.php?cid=' . (int)$cid);
?>