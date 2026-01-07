<?php

/**
 * Mengalihkan halaman ke URL tertentu dan menghentikan eksekusi script.
 * @param string $url Alamat tujuan redirect.
 */
function redirect_ke($url)
{
    header("Location: " . $url);
    exit(); // Penting untuk memastikan script di bawahnya tidak berjalan
}

/**
 * Membersihkan input string dari spasi di awal/akhir dan mencegah XSS.
 * @param string $str String mentah dari input user.
 * @return string String yang sudah aman untuk ditampilkan di HTML.
 */
function bersihkan($str)
{
    // trim() menghapus spasi, htmlspecialchars() mengubah karakter khusus menjadi entitas HTML
    return htmlspecialchars(trim($str));
}

/**
 * Validasi untuk mengecek apakah string tidak kosong.
 * @param string $str String yang akan dicek.
 * @return bool True jika berisi karakter, False jika kosong atau hanya spasi.
 */
function tidakKosong($str)
{
    return strlen(trim($str)) > 0;
}

/**
 * Mengubah format tanggal dari database (YYYY-MM-DD) ke format yang mudah dibaca.
 * @param string $tgl Tanggal asli.
 * @return string Tanggal dalam format "01 Jan 2025 10:00:00".
 */
function formatTanggal($tgl)
{
    return date("d M Y H:i:s", strtotime($tgl));
}

/**
 * Menghasilkan markup HTML untuk menampilkan daftar biodata berdasarkan konfigurasi.
 * @param array $conf Array pengaturan (label dan suffix).
 * @param array $arr Array data (isi biodata).
 * @return string Gabungan tag <p> yang berisi informasi biodata.
 */
function tampilkanBiodata($conf, $arr)
{
    $html = "";
    // Melakukan perulangan pada setiap baris konfigurasi field
    foreach ($conf as $k => $v) {
        $label  = $v["label"];
        // Mengambil nilai dari data berdasarkan kunci, jika tidak ada maka string kosong
        $nilai  = bersihkan($arr[$k] ?? '');
        $suffix = $v["suffix"];

        // Menyusun baris informasi ke dalam variabel string
        $html .= "<p><strong>{$label}</strong> {$nilai}{$suffix}</p>";
    }
    return $html;
}