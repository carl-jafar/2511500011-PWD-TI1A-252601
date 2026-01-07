<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  <?php
session_start();
require_once __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

if (isset($_POST['btnUpdateBio'])) {
    $id     = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nama   = bersihkan($_POST['txtNmLengkapEd']);
    $tempat = bersihkan($_POST['txtT4LhrEd']);
    $tgl    = bersihkan($_POST['txtTglLhrEd']);
    $hobi   = bersihkan($_POST['txtHobiEd']);
    $kerja  = bersihkan($_POST['txtKerjaEd']);

    if (!$id || !$nama) {
        $_SESSION['flash_error'] = "Data tidak lengkap.";
        redirect_ke("edit_biodata.php?id=$id");
    }

    $sql = "UPDATE tbl_biodata_mhs SET 
            nama_lengkap = ?, tempat_lahir = ?, tanggal_lahir = ?, 
            hobi = ?, pekerjaan = ? WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $nama, $tempat, $tgl, $hobi, $kerja, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash_sukses'] = "Biodata berhasil diperbarui!";
        redirect_ke('read.php');
    } else {
        $_SESSION['flash_error'] = "Gagal memperbarui data.";
        redirect_ke("edit_biodata.php?id=$id");
    }
    mysqli_stmt_close($stmt);
}

  #validasi cid wajib angka dan > 0
  $cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);

  if (!$cid) {
    $_SESSION['flash_error'] = 'CID Tidak Valid.';
    redirect_ke('read.php');
  }

  /*
    Prepared statement untuk anti SQL injection.
    menyiapkan query UPDATE dengan prepared statement 
    (WAJIB WHERE cid = ?)
  */
  $stmt = mysqli_prepare($conn, "DELETE FROM tbl_tamu
                                WHERE cid = ?");
  if (!$stmt) {
    #jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('read.php');
  }

  #bind parameter dan eksekusi (s = string, i = integer)
  mysqli_stmt_bind_param($stmt, "i", $cid);

  if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value
    /*
      Redirect balik ke read.php dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah dihapus.';
  } else { #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['flash_error'] = 'Data gagal dihapus. Silakan coba lagi.';
  }
  #tutup statement
  mysqli_stmt_close($stmt);

  redirect_ke('read.php');