<?php
require 'koneksi.php';

$fieldContact = [
    "nama" => ["label" => "Nama:", "suffix" => ""],
    "email" => ["label" => "Email:", "suffix" => ""],
    "pesan" => ["label" => "Tulis pesan anda:", "suffix" => ""]
];

$sql = "SELECT cid, cnama, cemail, cpesan, dcreated_at FROM tbl_tamu ORDER BY cid DESC";
$q = mysqli_query($conn, $sql);
if (!$q){
    echo"<p>gagal membaca data tamu: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
}

$no = 1;
?>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th> 
        <th>Aksi</th> <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Pesan</th>
        <th>Created At</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($q)): ?>
    <tr>
        <td><?= $no++; ?> </td>
        <td><?= $row['cid'];?> </td>
        <td><?= htmlspecialchars($row['cnama']); ?></td>
        <td><?= htmlspecialchars($row['cemail']); ?></td>
        <td><?= nl2br(htmlspecialchars($row['cpesan'])); ?></td>
    </tr>
    <?php endwhile; ?>
</table>