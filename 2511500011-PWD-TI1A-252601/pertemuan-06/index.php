
  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWD - Form Validasi</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <header>
      <h1>Ini Header</h1>
      <button class="menu-toggle" id="menu-toggle" aria-label="toggle-nav">&#9776;</button>
      <nav>
        <ul>
          <li><a href="#home">Beranda</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#kontak">Kontak</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <section id="home">
        <h2>Selamat Datang</h2>
          <?php
            $nim = "2511500011"
          ?>
        <p>Ini contoh paragraf HTML5.</p>
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
        
      </section>

      <section id="kontak">
        <h2>Kontak Kami</h2>
        <form id="formKontak" action="" method="get">
          <label for="txtNama">Nama :</label>
          <input type="text" id="txtNama" name="txtnama" placeholder="Masukkan nama anda" required autocomplete="name">

          <label for="txtEmail">Email :</label>
          <input type="text" id="txtEmail" name="txtemail" placeholder="Masukkan email anda" required autocomplete="email">

          <label for="txtPesan">Pesan :</label>
          <textarea id="txtPesan" name="txtpesan" rows="4" placeholder="Tulis pesan anda..." required></textarea>

          <p>
            <button type="submit">Kirim</button>
            <button type="reset">Batal</button>
          </p>
        </form>
      </section>

      <section id="about">
  <h2>Nilai Saya</h2>

  <?php

  $matkul = [
    ["nama" => "Algoritma dan Struktur Data", "sks" => 4, "hadir" => 90, "tugas" => 60, "uts" => 80, "uas" => 70],
    ["nama" => "Agama", "sks" => 2, "hadir" => 70, "tugas" => 50, "uts" => 60, "uas" => 80],
    ["nama" => "Matematika Diskrit", "sks" => 4, "hadir" => 80, "tugas" => 70, "uts" => 85, "uas" => 75],
    ["nama" => "Basis Data", "sks" => 3, "hadir" => 75, "tugas" => 65, "uts" => 70, "uas" => 85],
    ["nama" => "Pemrograman Web Dasar", "sks" => 3, "hadir" => 69, "tugas" => 80, "uts" => 90, "uas" => 100],
  ];

  function hitungGrade($nilaiAkhir, $nilaiHadir) {
    if ($nilaiHadir < 70) return ['E', 0.00];
    elseif ($nilaiAkhir >= 91) return ['A', 4.00];
    elseif ($nilaiAkhir >= 81) return ['A-', 3.70];
    elseif ($nilaiAkhir >= 76) return ['B+', 3.30];
    elseif ($nilaiAkhir >= 71) return ['B', 3.00];
    elseif ($nilaiAkhir >= 66) return ['B-', 2.70];
    elseif ($nilaiAkhir >= 61) return ['C+', 2.30];
    elseif ($nilaiAkhir >= 56) return ['C', 2.00];
    elseif ($nilaiAkhir >= 51) return ['C-', 1.70];
    elseif ($nilaiAkhir >= 36) return ['D', 1.00];
    else return ['E', 0.00];
  }

  $totalBobot = 0;
  $totalSKS = 0;

  foreach ($matkul as $m) {
    $nilaiAkhir = (0.1 * $m['hadir']) + (0.2 * $m['tugas']) + (0.3 * $m['uts']) + (0.4 * $m['uas']);
    list($grade, $mutu) = hitungGrade($nilaiAkhir, $m['hadir']);
    $bobot = $mutu * $m['sks'];
    $status = ($grade == 'D' || $grade == 'E') ? "Gagal" : "Lulus";

    $totalBobot += $bobot;
    $totalSKS += $m['sks'];

    echo "
    <div class='nilai-card'>
      <h3>" . htmlspecialchars($m['nama']) . "</h3>
      <p><strong>SKS:</strong> {$m['sks']}</p>
      <p><strong>Kehadiran:</strong> {$m['hadir']}</p>
      <p><strong>Tugas:</strong> {$m['tugas']}</p>
      <p><strong>UTS:</strong> {$m['uts']}</p>
      <p><strong>UAS:</strong> {$m['uas']}</p>
      <p><strong>Nilai Akhir:</strong> " . number_format($nilaiAkhir, 2) . "</p>
      <p><strong>Grade:</strong> $grade</p>
      <p><strong>Mutu:</strong> " . number_format($mutu, 2) . "</p>
      <p><strong>Bobot:</strong> " . number_format($bobot, 2) . "</p>
      <p><strong>Status:</strong> 
        <span style='color:" . ($status == "Lulus" ? "#2e7d32" : "#c62828") . "; font-weight:bold;'>
          $status
        </span>
      </p>
    </div>
    ";
  }

  $IPK = $totalBobot / $totalSKS;

  echo "
  <div class='nilai-card ipk'>
    <h3>Rekapitulasi</h3>
    <p><strong>Total SKS:</strong> $totalSKS</p>
    <p><strong>Total Bobot:</strong> " . number_format($totalBobot, 2) . "</p>
    <p><strong>IPK:</strong> <span style='color:#003366; font-weight:bold;'>" . number_format($IPK, 2) . "</span></p>
  </div>
  ";
  ?>
</section>
  
      </section>
    </main>

    <footer>
      <p>&#128512; 2025 (Muhammad Haikal)</p>
    </footer>

    <script src="script.js"></script>
  </body>
  </html>