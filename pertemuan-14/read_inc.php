<?php
// Memanggil file koneksi database agar variabel $conn dapat digunakan
require 'koneksi.php';

// Menentukan konfigurasi tampilan untuk setiap baris data tamu
// Field 'nama', 'email', dan 'pesan' dipetakan sesuai kunci array yang akan ditampilkan
$fieldContact = [
  "nama" => ["label" => "Nama:", "suffix" => ""],
  "email" => ["label" => "Email:", "suffix" => ""],
  "pesan" => ["label" => "Pesan Anda:", "suffix" => ""]
];

// Menyiapkan instruksi SQL untuk mengambil semua data dari tabel tamu
// ORDER BY cid DESC memastikan pesan terbaru muncul paling atas
$sql = "SELECT * FROM tbl_tamu ORDER BY cid DESC";

// Menjalankan query ke database
$q = mysqli_query($conn, $sql);

// Cek jika query gagal (misalnya karena tabel tidak ada atau kesalahan sintaks)
if (!$q) {
  echo "<p>Gagal membaca data tamu: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
} 
// Cek jika query berhasil tapi tidak ada data (baris kosong) di tabel
elseif (mysqli_num_rows($q) === 0) {
  echo "<p>Belum ada data tamu yang tersimpan.</p>";
} 
// Jika ada data, lakukan perulangan untuk menampilkan setiap baris
else {
  // mysqli_fetch_assoc mengambil baris data satu per satu dalam bentuk array asosiatif
  while ($row = mysqli_fetch_assoc($q)) {
    // Memetakan data dari kolom database (cnama, cemail, cpesan) ke format array lokal
    // Operator ?? "" digunakan sebagai pengaman jika data di database bernilai NULL
    $arrContact = [
      "nama"  => $row["cnama"]  ?? "",
      "email" => $row["cemail"] ?? "",
      "pesan" => $row["cpesan"] ?? "",
    ];

    // Memanggil fungsi tampilkanBiodata() dari fungsi.php untuk mencetak markup HTML
    // Fungsi ini mengubah data array menjadi paragraf yang rapi sesuai $fieldContact
    echo tampilkanBiodata($fieldContact, $arrContact);
  }
}
?>