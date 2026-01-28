<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  // 1. Ambil ID dari URL dan Validasi (menggunakan 'id', bukan 'cid')
  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);

  if (!$id) {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
  }

  // 2. Ambil data lama dari tbl_biodata_mhs
  $stmt = mysqli_prepare($conn, "SELECT * FROM tbl_biodata_mhs WHERE id = ? LIMIT 1");
  if (!$stmt) {
    $_SESSION['flash_error'] = 'Query error.';
    redirect_ke('read.php');
  }

  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);

  if (!$row) {
    $_SESSION['flash_error'] = 'Data mahasiswa tidak ditemukan.';
    redirect_ke('read.php');
  }

  // Ambil error jika ada dari proses sebelumnya
  $flash_error = $_SESSION['flash_error'] ?? '';
  unset($_SESSION['flash_error']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Biodata Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Edit Data Mahasiswa</h1>
        <nav>
            <ul>
                <li><a href="index.php">Form Input</a></li>
                <li><a href="read.php">Daftar Record</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="biodata">
            <h2>Ubah Biodata: <?= htmlspecialchars($row['nama_lengkap']); ?></h2>

            <?php if (!empty($flash_error)): ?>
            <div style="padding:10px; margin-bottom:10px; background:#f8d7da; color:#721c24; border-radius:6px;">
                <?= $flash_error; ?>
            </div>
            <?php endif; ?>

            <form action="proses_update_bio.php" method="POST">

                <input type="hidden" name="id" value="<?= (int)$id; ?>">

                <label for="txtkddsn"><span>kode dosen (Tidak dapat diubah):</span>
                    <label for="txtKodeDos"><span>Kode Dosen:</span>
                        <input type="text" id="txtKodeDos" name="txtKodeDos" placeholder="Masukkan Kode Dosen" required>
                    </label>

                    <label for="txtNmDosen"><span>Nama Dosen:</span>
                        <input type="text" id="txtNmDosen" name="txtNmDosen" placeholder="Masukkan Nama Dosen" required>
                    </label>

                    <label for="txtAlRmh"><span>Alamat Rumah:</span>
                        <input type="text" id="txtAlRmh" name="txtAlRmh" placeholder="Masukkan Alamat Rumah" required>
                    </label>

                    <label for="txtTglDosen"><span>Tanggal Jadi Dosen:</span>
                        <input type="text" id="txtTglDosen" name="txtTglDosen" placeholder="Masukkan Tanggal Jadi Dosen"
                            required>
                    </label>

                    <label for="txtJJA"><span>JJA Dosen:</span>
                        <input type="text" id="txtJJA" name="txtJJA" placeholder="Masukkan JJA Dosen" required>
                    </label>

                    <label for="txtProdi"><span>Homebase Prodi:</span>
                        <input type="text" id="txtProdi" name="txtProdi" placeholder="Masukkan Homebase Prodi" required>
                    </label>

                    <label for="txtNoHP"><span>Nomor HP:</span>
                        <input type="text" id="txtNoHP" name="txtNoHP" placeholder="Masukkan Nomor HP" required>
                    </label>

                    <label for="txNamaPasangan"><span>Nama Pasangan:</span>
                        <input type="text" id="txNamaPasangan" name="txNamaPasangan"
                            placeholder="Masukkan Nama Pasangan" required>
                    </label>

                    <label for="txtNmAnak"><span>Nama Anak:</span>
                        <input type="text" id="txtNmAnak" name="txtNmAnak" placeholder="Masukkan Nama Anak" required>
                    </label>

                    <label for="txtBidangIlmu"><span>Bidang Ilmu Dosen:</span>
                        <input type="text" id="txtBidangIlmu" name="txtBidangIlmu"
                            placeholder="Masukkan Bidang Ilmu Dosen" required>
                    </label>

                    <button type="submit" name="btnUpdateBio">Kirim</button>
                    <a href="read.php" style="margin-left:10px;">Batal</a>
            </form>
        </section>
    </main>
</body>

</html>