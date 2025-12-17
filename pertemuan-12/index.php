<?php
session_start();
require_once __DIR__ . '/fungsi.php';
require_once __DIR__ . '/koneksi.php';

$is_verified = $_SESSION['verified'] ?? false;

    if (empty($_SESSION['captcha_num1']) || empty($_SESSION['captcha_num2'])) {
        $_SESSION['captcha_num1'] = 2;
        $_SESSION['captcha_num2'] = 3;
    }
    $captcha_soal = $_SESSION['captcha_num1'] . " + " . $_SESSION['captcha_num2'];
    
    $captcha_error = $_SESSION['captcha_error'] ?? '';
    unset($_SESSION['captcha_error']);



$biodata = $_SESSION["biodata"] ?? [];
$fieldConfig = [
    "nim" => ["label" => "NIM:", "suffix" => ""],
    "nama" => ["label" => "Nama Lengkap:", "suffix" => " &#128526;"],
    "tempat" => ["label" => "Tempat Lahir:", "suffix" => ""],
    "tanggal" => ["label" => "Tanggal Lahir:", "suffix" => ""],
    "hobi" => ["label" => "Hobi:", "suffix" => " &#127926;"],
    "pasangan" => ["label" => "Pasangan:", "suffix" => " &hearts;"],
    "pekerjaan" => ["label" => "Pekerjaan:", "suffix" => " &copy; 2025"],
    "ortu" => ["label" => "Nama Orang Tua:", "suffix" => ""],
    "kakak" => ["label" => "Nama Kakak:", "suffix" => ""],
    "adik" => ["label" => "Nama Adik:", "suffix" => ""],
];

$flash_sukses = $_SESSION['flash_sukses'] ?? '';
$flash_error  = $_SESSION['flash_error'] ?? '';
$old          = $_SESSION['old'] ?? [];
unset($_SESSION['flash_sukses'], $_SESSION['flash_error'], $_SESSION['old']);

$fieldContact = [
    "no" => ["label" => "No:", "suffix" => ""],
    "cnama" => ["label" => "Nama:", "suffix" => ""],
    "cemail" => ["label" => "Email:", "suffix" => ""],
    "cpesan" => ["label" => "Pesan:", "suffix" => ""],
    "dcreated_at" => ["label" => "Created At:", "suffix" => ""],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judul Halaman</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php if (!$is_verified): ?>

    <section id="verification-form"
        style="text-align: center; padding: 50px; border: 1px solid #ccc; max-width: 400px; margin: 100px auto;">
        <h2>Verifikasi Akses</h2>
        <?php if (!empty($captcha_error)): ?>
        <div style="padding: 10px; margin-bottom: 10px; background:#f8d7da; color:#721c24; border-radius:6px;">
            <?= $captcha_error ?>
        </div>
        <?php endif; ?>

        <form action="proses.php" method="POST">
            <label for="initialCaptcha"><span>Berapakah hasil dari: **<?= $captcha_soal ?>**?</span>
                <input type="text" id="initialCaptcha" name="initialCaptcha" placeholder="Masukkan jawaban" required
                    style="display: block; width: 100%; margin: 10px 0;">
            </label>
            <button type="submit" name="check_access">Verifikasi</button>
        </form>
    </section>

    <?php else: ?>

    <header>
        <h1>Ini Header</h1>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
            &#9776;
        </button>
        <nav>
            <ul>
                <li><a href="#home">Beranda</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home">
            <h2>Selamat Datang</h2>
            <?php
                echo "halo dunia!<br>";
                echo "nama saya hadi";
                ?>
            <p>Ini contoh paragraf HTML.</p>
        </section>

        <section id="biodata">
            <h2>Biodata Sederhana Mahasiswa</h2>
            <form action="proses.php" method="POST">
                <label for="txtNim"><span>NIM:</span>
                    <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM" required>
                </label>

                <label for="txtNmLengkap"><span>Nama Lengkap:</span>
                    <input type="text" id="txtNmLengkap" name="txtNmLengkap" placeholder="Masukkan Nama Lengkap"
                        required autocomplete="name">
                </label>
                <label for="txtT4Lhr"><span>Tempat Lahir:</span>
                    <input type="text" id="txtT4Lhr" name="txtT4Lhr" placeholder="Masukkan Tempat Lahir" required>
                </label>
                <label for="txtTglLhr"><span>Tanggal Lahir:</span>
                    <input type="date" id="txtTglLhr" name="txtTglLhr" placeholder="Masukkan Tanggal Lahir" required>
                </label>
                <label for="txtHobi"><span>Hobi:</span>
                    <input type="text" id="txtHobi" name="txtHobi" placeholder="Masukkan Hobi" required>
                </label>
                <label for="txtPasangan"><span>Pasangan:</span>
                    <input type="text" id="txtPasangan" name="txtPasangan" placeholder="Masukkan Pasangan" required>
                </label>
                <label for="txtKerja"><span>Pekerjaan:</span>
                    <input type="text" id="txtKerja" name="txtKerja" placeholder="Masukkan Pekerjaan" required>
                </label>
                <label for="txtNmOrtu"><span>Nama Orang Tua:</span>
                    <input type="text" id="txtNmOrtu" name="txtNmOrtu" placeholder="Masukkan Nama Orang Tua" required>
                </label>
                <label for="txtNmKakak"><span>Nama Kakak:</span>
                    <input type="text" id="txtNmKakak" name="txtNmKakak" placeholder="Masukkan Nama Kakak" required>
                </label>
                <label for="txtNmAdik"><span>Nama Adik:</span>
                    <input type="text" id="txtNmAdik" name="txtNmAdik" placeholder="Masukkan Nama Adik" required>
                </label>

                <button type="submit">Kirim</button>
                <button type="reset">Batal</button>
            </form>
        </section>

        <section id="about">
            <h2>Tentang Saya</h2>
            <?= tampilkanBiodata($fieldConfig, $biodata) ?>
        </section>

        <section id="contact">
            <h2>Kontak Kami</h2>

            <?php if (!empty($flash_sukses)): ?>
            <div style="padding: 10px; margin-bottom: 10px; background:#d4edda; color:#155724; border-radius:6px;">
                <?= $flash_sukses ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($flash_error)): ?>
            <div style="padding: 10px; margin-bottom: 10px; background:#f8d7da; color:#721c24; border-radius:6px;">
                <?= $flash_error ?>
            </div>
            <?php endif; ?>

            <form action="proses.php" method="POST">
                <label for="txtNama"><span>Nama:</span>
                    <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama" required
                        autocomplete="name" value="<?= bersihkan($old['cnama'] ?? '') ?>">
                </label>

                <label for="txtEmail"><span>Email:</span>
                    <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email" required
                        autocomplete="email" value="<?= bersihkan($old['cemail'] ?? '') ?>">
                </label>

                <label for="txtPesan"><span>Pesan Anda:</span>
                    <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..."
                        required><?= bersihkan($old['cpesan'] ?? '') ?></textarea>
                </label>

                <label for="txtCaptcha"><span>Berapakah hasil dari: **<?= $captcha_soal ?>**?</span>
                    <input type="number" id="txtCaptcha" name="txtCaptcha" placeholder="Jawaban angka" required>
                </label>

                <button type="submit">Kirim</button>
                <button type="reset">Batal</button>
            </form>
            <br>
            <hr>
            <h2>Yang menghubungi kami</h2>

            <?php 
                $query_tamu = "SELECT cnama, cemail, cpesan, dcreated_at FROM tbl_tamu ORDER BY cid DESC";
                $result = mysqli_query($conn, $query_tamu);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($contact = mysqli_fetch_assoc($result)) {
                        echo tampilkanBiodata($fieldContact, $contact);
                        echo "<hr>";
                    } 
                } else {
                    echo "<p>Belum ada data kontak dalam database.</p>";
                }
                mysqli_close($conn); 
                ?>

        </section>
    </main>

    <?php endif; ?>

    <footer>
        <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>