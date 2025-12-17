<?php
session_start();
require 'koneksi.php';
require 'fungsi.php';

// 1. Inisialisasi variabel agar form tidak error saat pertama kali dimuat
$nama = $email = $pesan = '';

// 2. Validasi ID dari URL
$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$cid) {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

// 3. Menyiapkan Prepared Statement untuk keamanan dari SQL Injection
$stmt = mysqli_prepare($conn, "SELECT cid, cnama, cpesan, cemail FROM tbl_tamu WHERE cid = ? LIMIT 1");

if (!$stmt) {
    $_SESSION['flash_error'] = 'Gagal menyiapkan query database.';
    redirect_ke('read.php');
}

// 4. Proses pengambilan data
mysqli_stmt_bind_param($stmt, "i", $cid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt); // Perbaikan: Menambah '='
$row = mysqli_fetch_assoc($res);      // Perbaikan: Menambah '=' dan menggunakan hasil $res
mysqli_stmt_close($stmt);

// 5. Cek apakah data ditemukan
if (!$row) {
    $_SESSION['flash_error'] = 'Data tidak ditemukan di dalam sistem.';
    redirect_ke('read.php');
} else {
    // Isi variabel dengan data asli dari database
    $nama  = $row['cnama'];
    $email = $row['cemail'];
    $pesan = $row['cpesan'];
}

// 6. Cek jika ada inputan lama dari session (misal jika submit gagal karena captcha salah)
if (isset($_SESSION['old'])) {
    $nama  = $_SESSION['old']['txtNamaEd']  ?? $nama;
    $email = $_SESSION['old']['txtEmailEd'] ?? $email;
    $pesan = $_SESSION['old']['txtPesanEd'] ?? $pesan;
    unset($_SESSION['old']);
}

// 7. Ambil pesan error untuk ditampilkan di bawah
$flash_error = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_error']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku Tamu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Aplikasi Buku Tamu</h1>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
            &#9776;
        </button>
        <nav>
            <ul>
                <li><a href="read.php">Daftar Tamu</a></li>
                <li><a href="#">Beranda</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="contact">
            <h2>Edit Buku Tamu</h2>

            <?php if (!empty($flash_error)): ?>
                <div style="padding:10px; margin-bottom:15px; background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; border-radius:6px;">
                    <?= htmlspecialchars($flash_error); ?>
                </div>
            <?php endif; ?>

            <form action="proses_update.php" method="POST">
                
                <input type="hidden" name="cid" value="<?= (int)$cid; ?>">

                <label for="txtNama"><span>Nama:</span>
                    <input type="text" id="txtNama" name="txtNamaEd" 
                           placeholder="Masukkan nama" required 
                           value="<?= htmlspecialchars($nama); ?>">
                </label>

                <label for="txtEmail"><span>Email:</span>
                    <input type="email" id="txtEmail" name="txtEmailEd" 
                           placeholder="Masukkan email" required 
                           value="<?= htmlspecialchars($email); ?>">
                </label>

                <label for="txtPesan"><span>Pesan Anda:</span>
                    <textarea id="txtPesan" name="txtPesanEd" rows="4" 
                              placeholder="Tulis pesan anda..." 
                              required><?= htmlspecialchars($pesan); ?></textarea>
                </label>

                <label for="txtCaptcha"><span>Keamanan: 2 x 3 = ?</span>
                    <input type="number" id="txtCaptcha" name="txtCaptcha" 
                           placeholder="Jawab hasil perkalian..." required>
                </label>

                <div class="button-group">
                    <button type="submit" style="cursor:pointer;">Simpan Perubahan</button>
                    <button type="reset" style="cursor:pointer;">Reset</button>
                    <a href="read.php" class="btn-back">Kembali</a>
                </div>
            </form>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>