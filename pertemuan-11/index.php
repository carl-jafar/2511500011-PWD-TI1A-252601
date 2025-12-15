<?php
session_start();
require_once __DIR__ . '/fungsi.php';
require_once __DIR__ . '/koneksi.php';

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
    "cnama" => ["label" => "Nama:", "suffix" => ""],
    "cemail" => ["label" => "Email:", "suffix" => ""],
    "cpesan" => ["label" => "Pesan:", "suffix" => ""],
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

            <?php if ($flash_sukses): ?>
            <p style="color: green; border: 1px solid green; padding: 10px; background-color: #e6ffe6;">
                <?= $flash_sukses ?></p>
            <?php endif; ?>

            <?php if ($flash_error): ?>
            <p style="color: red; border: 1px solid red; padding: 10px; background-color: #ffe6e6;"><?= $flash_error ?>
            </p>
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
                    <small id="charCount">0/200 karakter</small>
                </label>

                <button type="submit">Kirim</button>
                <button type="reset">Batal</button>
            </form>

            <br>
            <hr>
            <h2>Yang menghubungi kami</h2>

            <?php 
            $query_tamu = "SELECT cnama, cemail, cpesan FROM tbl_tamu ORDER BY cid DESC";
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

    <footer>
        <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>