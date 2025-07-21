<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Health Shop</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="assets/style.css" />
</head>

<body>
  <section id="navbar">
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
      <div class="container-fluid">
        <img
          src="assets/image/icon-healthier.png"
          alt="Logo"
          style="width: 50px; height: 50px; margin: 10px"
          class="d-inline-block align-text-top" />
        <a class="navbar-brand mx-2" href="index.php">Health Shop</a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-end mr-3"
          id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="belanja.php">Belanja</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="cart.php?p=0">Keranjang</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="https://wa.me/+6281240277417">Kontak Kami</a>
            </li>
          </ul>
          <ul class="navbar-nav mx-4">
            <?php
            if (!isset($_SESSION['log'])) {
              echo '
					<li><a href="register.php" class="btn btn-light mx-2"> Register</a></li>
					<li><a href="login.php" class="btn btn-light">Login</a></li>
					';
            } else {

              if ($_SESSION['role'] == 'member') {
                echo '
          <li><a href="account.php" class="btn btn-light mx-2">Account</a></li>
					<li><a href="logout.php" class="btn btn-light mb-1">Logout</a></li>
					';
              } else {
                echo '
					<li><a href="admin" class="btn btn-light mb-1 mx-3">Admin</a></li>
					<li><a href="logout.php" class="btn btn-light mb-1">Logout</a></li>
					';
              };
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <section id="jumbotron">
    <div class="container-fluid py-5 jumbotron-bg text-center">
      <p class="p-5"></p>
      <img src="assets/image/icon-healthier.png" alt="logo" style="width: 100px; height: 100px">
      <h1 class="display-3 fw-bold">Health Shop</h1>
      <p>
      <h4>Tempat berbelanja alat kesehatan online yang praktis dan lengkap</h4>
      </p>
    </div>
  </section>

  <section id="solusi" class="container py-5 my-5">
    <div class="row text-center ">
      <div class="col-12 p-5">
        <h2 class="display-4">Solusi Terbaik dari Health Shop untuk Health People</h2>
      </div>
      <div class="col-12 col-sm-6 col-lg-3">
        <span class="fa-stack fa-4x">
          <i class="fa-solid fa-check-to-slot"></i>
        </span>
        <h3>Penjual Terpercaya dan Terverifikasi</h3>
        <p class="pb-5">Semua penjual di platform kami telah melalui proses verifikasi yang ketat.</p>
      </div>
      <div class="col-12 col-sm-6 col-lg-3">
        <span class="fa-stack fa-4x">
          <i class="fa-regular fa-star"></i>
        </span>
        <h3>Produk Berkualitas</h3>
        <p class="pb-5">Hanya menjual alat kesehatan yang telah teruji kualitasnya.</p>
      </div>
      <div class="col-12 col-sm-6 col-lg-3">
        <span class="fa-stack fa-4x">
          <i class="fa-solid fa-truck-fast"></i>
        </span>
        <h3>Pengiriman Cepat</h3>
        <p class="pb-5">Kami menjamin pengiriman yang cepat dan aman ke alamat Anda.</p>
      </div>
      <div class="col-12 col-sm-6 col-lg-3">
        <span class="fa-stack fa-4x">
          <i class="fa-solid fa-hand-holding-dollar"></i>
        </span>
        <h3>Harga Kompetitif</h3>
        <p class="pb-5">Dapatkan harga terbaik dengan penawaran menarik setiap saat.</p>
      </div>
  </section>

  <?php include('footer.php') ?>


  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>