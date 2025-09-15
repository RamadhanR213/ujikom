<?php
session_start();
include '../koneksi.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$result = mysqli_query($conn, "SELECT p.*, u.username 
                               FROM pembayaran p 
                               JOIN pendaftar u ON p.user_id=u.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Pembayaran</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
</head>
<body class="container mt-5">
  <h2>Data Metode Pembayaran User</h2>
  <table class="table table-bordered">
    <tr>
      <th>Username</th>
      <th>Metode</th>
      <th>Nomor</th>
      <th>Atas Nama</th>
      <th>Waktu Tambah</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['metode']; ?></td>
      <td><?php echo $row['nomor']; ?></td>
      <td><?php echo $row['atas_nama']; ?></td>
      <td><?php echo $row['created_at']; ?></td>
    </tr>
    <?php } ?>
  </table>
</body>
</html>
