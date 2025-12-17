<?php
session_start();
require 'koneksi.php';
require 'fungsi.php';

$sql = "SELECT * from tbl_tamu order by cid desc";
$q = mysqli_query($conn, $sql);
if (!$q) {
    die("Querry error: " . mysqli_error($conn));
}
?>

<?php
    $flash_sukses = $_SESSION['flash_sukses'] ?? '';
    $flash_error  = $_SESSION['flash_error'] ?? '';
    unset($_SESSION['flash_sukses'], $_SESSION['flash_error'])
?>

<?php if (!empty($flash_sukses)): ?>
    <div style="padding: 10px; margin-bottom:10px; background:#d4edda; color:#155724; border-radius:6px;">
        <?= $flash_sukses?>
    </div>
    <?php endif; ?>

<?php if (!empty($flash_error)): ?>
    <div style="padding: 10px; margin-bottom:10px; background:#f8d7da; color:#721c24; border-radius:6px;">
        <?= $flash_error?>
    </div>
    <?php endif; ?>

<table border= "1" cellpadding="8" cellspacing="0">
 <tr>
    <th>no</th>
    <th>aksi</th>
    <th>id</th>
    <th>nama</th>
    <th>email</th>
    <th>pesan</th>
    <th>Created At</th>
</tr>

<?php 
$i = 1;
while($row = mysqli_fetch_assoc($q)): ?>
    <tr>
        <td><?= $i++?></td>
        <td><?= $row['cid'];?> </td>
        <td><?= $row['cid'];?> </td>
        <td><?= htmlspecialchars($row['cnama']); ?></td>
        <td><?= htmlspecialchars($row['cemail']); ?></td>
        <td><?= nl2br(htmlspecialchars($row['cpesan'])); ?></td>
        <td><?= $row['dcreated_at']?></td>
    </tr>
<?php endwhile; ?>
</table>