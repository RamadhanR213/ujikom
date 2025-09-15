<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['log']) || $_SESSION['role'] != 'member') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $user_id = $_SESSION['id']; // pastikan session id user disimpan saat login
    $metode = mysqli_real_escape_string($conn, $_POST['metode']);
    $nomor = mysqli_real_escape_string($conn, $_POST['nomor']);
    $atas_nama = mysqli_real_escape_string($conn, $_POST['atas_nama']);

    $insert = mysqli_query($conn, "INSERT INTO pembayaran (user_id, metode, nomor, atas_nama) 
                                   VALUES ('$user_id', '$metode', '$nomor', '$atas_nama')");
    if ($insert) {
        echo "<script>alert('Metode pembayaran berhasil ditambahkan');window.location='account.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Metode Pembayaran</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
</head>
<body class="container mt-5">
  <h2>Tambah Metode Pembayaran</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Metode Pembayaran</label>
      <select name="metode" class="form-control" required>
        <option value="Bank BCA">Bank BCA</option>
        <option value="Bank BNI">Bank BNI</option>
        <option value="Bank Mandiri">Bank Mandiri</option>
        <option value="OVO">OVO</option>
        <option value="DANA">DANA</option>
        <option value="Gopay">Gopay</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Nomor Rekening / No HP</label>
      <input type="text" name="nomor" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Atas Nama</label>
      <input type="text" name="atas_nama" class="form-control" required>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
  </form>
</body>
</html>
