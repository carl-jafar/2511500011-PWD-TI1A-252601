<?php
require 'koneksi.php';

$sql = "SELECT * from tbl_tamu order by cid desc";
$q = mysqli_query($conn, $sql)
?>
<table border= "1" cellpadding="8" cellspacing="0">
 <tr>
    <th>id</th>
    <th>nama</th>
    <th>email</th>
    <th>pesan</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($q)): ?>
    <tr>
        <td><?= $row['cid'];?> </td>
        <td><?= htmlspecialchars($row['cnama']); ?></td>
        <td><?= htmlspecialchars($row['cemail']); ?></td>
        <td><?= nl2br(htmlspecialchars($row['cpesan'])); ?></td>
    </tr>
<?php endwhile; ?>
</table>