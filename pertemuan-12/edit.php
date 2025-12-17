<?php
session_start();
require 'koneksi.php';
require 'fungsi.php';

$nama = $email = $pesan = '';

$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

if (!$cid) {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
}

$stmt = mysqli_prepare($conn, "SELECT cid, cnama, cpesan, cemail FROM tbl_tamu WHERE cid = ? LIMIT 1");

if (!$stmt) {
    $_SESSION['flash_error'] = 'Gagal menyiapkan query database.';
    redirect_ke('read.php');
}

mysqli_stmt_bind_param($stmt, "i", $cid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt); 
$row = mysqli_fetch_assoc($res); 
mysqli_stmt_close($stmt);
if (!$row) {
    $_SESSION['flash_error'] = 'Data tidak ditemukan di dalam sistem.';
    redirect_ke('read.php');
} else {
    $nama  = $row['cnama'];
    $email = $row['cemail'];
    $pesan = $row['cpesan'];
}

if (isset($_SESSION['old'])) {
    $nama  = $_SESSION['old']['nama']    ?? $nama;
    $email = $_SESSION['old']['email']   ?? $email;
    $pesan = $_SESSION['old']['pesan']   ?? $pesan;
    unset($_SESSION['old']);
}

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
            <div
                style="padding:10px; margin-bottom:15px; background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; border-radius:6px;">
                <?= $flash_error;?>
            </div>
            <?php endif; ?>

            <form action="proses_update.php" method="POST">
                <label for="cid"><span></span>
                    <input type="text" name="cid" value="<?= (int)$cid; ?>">
                </label>

                <label for="txtNama"><span>Nama:</span>
                    <input type="text" id="txtNama" name="txtNamaEd" required value="<?= htmlspecialchars($nama); ?>">
                </label>

                <label for="txtEmail"><span>Email:</span>
                    <input type="email" id="txtEmail" name="txtEmailEd" required
                        value="<?= htmlspecialchars($email); ?>">
                </label>

                <label for="txtPesan"><span>Pesan Anda:</span>
                    <textarea id="txtPesan" name="txtPesanEd" rows="4"
                        required><?= htmlspecialchars($pesan); ?></textarea>
                </label>

                <label for="txtCaptcha"><span>Captcha 2 x 3 = ?</span>
                    <input type="number" id="txtCaptcha" name="txtCaptcha" placeholder="Jawab Pertanyaan..." required>
                </label>

                <div class="button-group">
                    <button type="submit">Kirim</button>
                    <button type="reset">Batal</button>
                    <a href="read.php">Kembali</a>
                </div>
            </form>
        </section>
    </main>
</body>

</html>