<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MedShop</title>
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
        <a class="navbar-brand mx-2" href="index.php">MedShop</a>
        
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
              <a class="nav-link"  href="index.php">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="belanja.php">Belanja</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="cart.php?p=0">Keranjang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="kontak.php">Kontak Kami</a>
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

<section id="kontak" class="container mt-5">
  <h2 class="text-center mb-4">Kontak Kami</h2>
  <div class="card shadow-lg p-4">
    <h5 class="text-center">Informasi Kontak</h5>
    <div class="row text-center mt-4">
      <!-- WhatsApp -->
      <div class="col-md-4">
        <a href="https://wa.me/6281234567890" target="_blank">
          <img src="assets/image/whatsapp-logo.png" alt="WhatsApp" style="width: 50px; height: 50px;">
        </a>
        <p class="mt-2"><strong>+62 812-3456-7890</strong></p>
      </div>
      <!-- Instagram -->
      <div class="col-md-4">
        <a href="https://instagram.com/medshop" target="_blank">
          <img src="assets/image/instagram-logo.png" alt="Instagram" style="width: 50px; height: 50px;">
        </a>
        <p class="mt-2"><strong>@medshop</strong></p>
      </div>
      <!-- Email -->
      <div class="col-md-4">
        <a href="mailto:info@medshop.com">
          <img src="assets/image/email-logo.png" alt="Email" style="width: 50px; height: 50px;">
        </a>
        <p class="mt-2"><strong>info@medshop.com</strong></p>
      </div>
    </div>
    <h5 class="mt-5">Alamat Outlet Fisik</h5>
    <div class="row">
      <?php
      include 'koneksi.php';

      $query = mysqli_query($conn, "SELECT * FROM outlet");

      if (!$query) {
          die("Query gagal: " . mysqli_error($conn));
      }

      while ($row = mysqli_fetch_assoc($query)) {
          echo '
          <div class="col-md-4 mb-4">
            <div class="card card-outlet">
              <img src="assets/image/' . $row['gambar'] . '" class="card-img-top" alt="' . $row['nama_outlet'] . '">
              <div class="card-body">
                <h5 class="card-title">' . $row['nama_outlet'] . '</h5>
                <p class="card-text">' . $row['alamat'] . '</p>
              </div>
            </div>
          </div>
          ';
      }
      ?>
    </div>
  </div>
</section>

  <?php include('footer.php') ?>
  
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>