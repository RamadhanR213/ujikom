<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['log']) || $_SESSION['role'] != 'member') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $user_id   = $_SESSION['id']; 
    $metode    = mysqli_real_escape_string($conn, $_POST['metode']);
    $nomor     = mysqli_real_escape_string($conn, $_POST['nomor']);
    $atas_nama = mysqli_real_escape_string($conn, $_POST['atas_nama']);

    // ✅ Cek apakah sudah ada metode & nomor yang sama
    $cek = mysqli_query($conn, "SELECT * FROM pembayaran 
                                WHERE user_id = '$user_id' 
                                AND metode = '$metode' 
                                AND nomor = '$nomor'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Metode pembayaran dengan nomor tersebut sudah ada!'); window.location='add_pembayaran.php';</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO pembayaran (user_id, metode, nomor, atas_nama) 
                                       VALUES ('$user_id', '$metode', '$nomor', '$atas_nama')");
        if ($insert) {
            echo "<script>alert('Metode pembayaran berhasil ditambahkan');window.location='account.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedShop - Tambah Metode Pembayaran</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/style.css" />
    <style>
    .navbar {
      background: linear-gradient(90deg, #0d6efd, #084298);
    }
    .navbar-brand, .nav-link, .btn {
      font-weight: 500;
    }
  </style>
</head>
<body>
    <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <img src="assets/image/profile.jpg" alt="Logo" style="width: 50px; height: 50px;" class="d-inline-block align-text-top" />
      <a class="navbar-brand mx-2" href="index.php">MedShop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="belanja.php">Belanja</a></li>
          <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang</a></li>
          <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak Kami</a></li>
        </ul>
        <ul class="navbar-nav mx-4">
          <?php
          if (!isset($_SESSION['log'])) {
            echo '
              <li><a href="register.php" class="btn btn-light mx-2">Register</a></li>
              <li><a href="login.php" class="btn btn-outline-light">Login</a></li>
            ';
          } else {
            if ($_SESSION['role'] == 'member') {
              echo '
                <li><a href="account.php" class="btn btn-light mx-2">Account</a></li>
                <li><a href="logout.php" class="btn btn-outline-light">Logout</a></li>
              ';
            } else {
              echo '
                <li><a href="admin" class="btn btn-light mx-3">Admin</a></li>
                <li><a href="logout.php" class="btn btn-outline-light">Logout</a></li>
              ';
            }
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <h2 class="container mt-5">Tambah Metode Pembayaran</h2>
  <form method="POST" class="container mt-5">
    <div class="mb-3">
      <label class="form-label">Metode Pembayaran</label>
      <select name="metode" class="form-control" required>
        <option value="Bank BCA">Bank BCA</option>
        <option value="Bank BNI">Bank BNI</option>
        <option value="Bank Mandiri">Bank Mandiri</option>
        <option value="OVO">OVO</option>
        <option value="DANA">DANA</option>
        <option value="Gopay">Gopay</option>
        <option value="COD">Cash On Delivery (COD)</option> <!-- ✅ Tambahan -->
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Nomor Rekening / No HP</label>
      <input type="text" name="nomor" class="form-control" placeholder="Isi jika diperlukan">
    </div>
    <div class="mb-3">
      <label class="form-label">Atas Nama</label>
      <input type="text" name="atas_nama" class="form-control" placeholder="Isi jika diperlukan">
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
  </form>

  <?php include('footer.php') ?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
