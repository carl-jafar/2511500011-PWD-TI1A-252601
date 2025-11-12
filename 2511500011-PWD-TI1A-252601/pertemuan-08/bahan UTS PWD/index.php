<?php
session_start();

$sesnama = "";
if (isset($_SESSION["sesnama"])):
  $sesnama = $_SESSION["sesnama"];
endif;

$sesemail = "";
if (isset($_SESSION["sesemail"])):
  $sesemail = $_SESSION["sesemail"];
endif;

$sespesan = "";
if (isset($_SESSION["sespesan"])):
  $sespesan = $_SESSION["sespesan"];
endif;
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
      echo "nama saya Haikal";
      ?>
      <p>Ini contoh paragraf HTML.</p>
    </section>

    <section id="tamu">
      <form action="proses.php">
        <form action="get_proses.php" method="GET">

        <label for="txtNim"><span>NIM:</span>
          <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM" required autocomplete="NIM">
        </label>

        <label for="txtNmLengkap"><span>Nama Lengkap:</span>
          <input type="email" id="txtNmLengkap" name="txtNmLengkap" placeholder="Masukkan Nama Lengkap" required autocomplete="Nama Lengkap">
        </label>

         <label for="txtlahir"><span>Tempat Lahir:</span>
          <input type="email" id="txtlahir" name="txtlahir" placeholder="Masukkan tempat Lahir" required autocomplete="Tempat Lahir">
        </label>

        <label for="txttgllahir"><span>Tanggal Lahir:</span>
          <input type="email" id="txttgllahir" name="txttgllahir" placeholder="Masukkan tanggal Lahir" required autocomplete="tanggal Lahir">
        </label>     

        <label for="txthobi"><span>Hobi:</span>
          <input type="hobi" id="txthobi" name="txthobi" placeholder="Masukkan hobi" required autocomplete="hobi">
        </label>

        <label for="txtpasangan"><span>pasangan:</span>
          <input type="pasangan" id="txthobi" name="txthobi" placeholder="Masukkan hobi" required autocomplete="hobi">
        </label>

        <label for="txtpekerjaan"><span>pekerjaan:</span>
          <input type="pekerjaan" id="txtpekerjaan" name="txtpekerjaan" placeholder="Masukkan pekerjaan" required autocomplete="pekerjaan">
        </label>

        <label for="txthobi"><span>Hobi:</span>
          <input type="hobi" id="txthobi" name="txthobi" placeholder="Masukkan hobi" required autocomplete="hobi">
        </label>

        <label for="txtOrtu"><span>Nama Orang Tua:</span>
          <input type="Ortu" id="txtOrtu" name="txtOrtu" placeholder="Masukkan Nama Ortu" required autocomplete="Ortu">
        </label>

        <label for="txtKakak"><span>Nama Kakak:</span>
          <input type="Kakak" id="txtKakak" name="txtKakak" placeholder="Masukkan Nama Kakak" required autocomplete="Kakak">
        </label>

         <label for="txtAdik"><span>Nama Adik:</span>
          <input type="Adik" id="txtAdik" name="txthobi" placeholder="Masukkan Nama Adik" required autocomplete="Adik">
        </label>

    </section>

    <section id="about">
        <h2>Tentang Saya</h2>
        <p><strong>NIM :</strong> 2511500011</p>
        <p><strong>Nama Lengkap :</strong> Muhammad Haikal</p>
        <p><strong>Tempat Lahir :</strong> Air Lintang</p>
        <p><strong>Tanggal Lahir :</strong> 16 Desember 2006</p>
        <p><strong>Hobi :</strong> Photography & Videografi</p>
        <p><strong>Pasangan :</strong> Belum ada</p>
        <p><strong>Pekerjaan :</strong> Kadang ada, kadang nganggur</p>
        <p><strong>Nama Orang Tua :</strong> Medi Hestri dan Sri Kustiani</p>
        <p><strong>Nama Kakak :</strong> Tidak ada</p>
        <p><strong>Nama Adik :</strong> Tidak ada</p>
        </label>
        </form>
    </section>

    <section id="contact">
      <h2>Kontak Kami</h2>
      <form action="proses.php" method="POST">

        <label for="txtNama"><span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama" required autocomplete="name">
        </label>

        <label for="txtEmail"><span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email" required autocomplete="email">
        </label>

        <label for="txtPesan"><span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..." required></textarea>
          <small id="charCount">0/200 karakter</small>
        </label>


        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>

      <?php if (!empty($sesnama)): ?>
        <br><hr>
        <h2>Yang menghubungi kami</h2>
        <p><strong>Nama :</strong> <?php echo $sesnama ?></p>
        <p><strong>Email :</strong> <?php echo $sesemail ?></p>
        <p><strong>Pesan :</strong> <?php echo $sespesan ?></p>
      <?php endif; ?>



    </section>
  </main>

  <footer>
    <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>