<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MedShop</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link rel="stylesheet" href="assets/style.css" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar {
      background: linear-gradient(90deg, #0d6efd, #084298);
    }
    .navbar-brand, .nav-link, .btn {
      font-weight: 500;
    }
    footer {
      background: linear-gradient(90deg, #0d6efd, #084298);
    }
    .carousel-item img {
      height: 33vh;
      object-fit: contain;
      transform: scale(0.9);
      transition: transform 0.5s ease-in-out;
    }
    .carousel-container {
      width: 50%;
      margin: 0 auto;
    }
    .flip-card {
      background-color: transparent;
      width: 100%;
      height: 300px;
      perspective: 1000px;
      cursor: pointer;
    }
    .flip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      text-align: center;
      transition: transform 0.8s;
      transform-style: preserve-3d;
    }
    .flip-card.flipped .flip-card-inner {
      transform: rotateY(180deg);
    }
    .flip-card-front,
    .flip-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      padding: 20px;
    }
    .flip-card-front {
      background-color: #ffffff;
    }
    .flip-card-back {
      background-color: #0d6efd;
      color: white;
      transform: rotateY(180deg);
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
          <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="belanja.php">Belanja</a></li>
          <li class="nav-item"><a class="nav-link" href="cart.php?p=0">Keranjang</a></li>
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

  <!-- Jumbotron / Carousel -->
  <section id="jumbotron">
    <div class="container-fluid py-5 text-center">
      <div class="carousel-container">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="assets/image/carousel1.png" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
              <img src="assets/image/carousel2.jpeg" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
              <img src="assets/image/carousel3.png" class="d-block w-100" alt="Slide 3">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Profile -->
  <section id="our-profile" class="container py-5 my-5">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h2 class="display-5 fw-bold text-primary">Our Profile</h2>
        <p class="lead">MedShop adalah platform e-commerce yang menyediakan berbagai produk kesehatan berkualitas tinggi.</p>
        <ul>
          <li><strong>Mission:</strong> Memberikan akses mudah ke produk kesehatan berkualitas.</li>
          <li><strong>Vision:</strong> Menjadi platform terpercaya di Indonesia.</li>
          <li><strong>Values:</strong> Integritas, inovasi, kepuasan pelanggan.</li>
        </ul>
      </div>
      <div class="col-md-6 text-center">
        <img src="assets/image/profile.jpg" alt="Our Profile" class="img-fluid rounded shadow">
      </div>
    </div>
  </section>

  <!-- Our Doctors -->
  <section id="our-doctors" class="py-5 bg-light">
    <div class="container">
      <h2 class="display-5 fw-bold text-center text-primary mb-4">Our Doctors</h2>
      <div class="row justify-content-center">
        <!-- Dokter 1 -->
        <div class="col-md-5 mb-4">
          <div class="flip-card" onclick="this.classList.toggle('flipped')">
            <div class="flip-card-inner">
              <div class="flip-card-front d-flex flex-column align-items-center justify-content-center">
                <img src="assets/image/doctor1.jpg" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h4>Dr. Andi Wijaya</h4>
                <p>Spesialis Farmasi Klinis</p>
              </div>
              <div class="flip-card-back d-flex flex-column align-items-center justify-content-center">
                <h5>Profil</h5>
                <p>Pengalaman lebih dari 10 tahun di farmasi klinis.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Dokter 2 -->
        <div class="col-md-5 mb-4">
          <div class="flip-card" onclick="this.classList.toggle('flipped')">
            <div class="flip-card-inner">
              <div class="flip-card-front d-flex flex-column align-items-center justify-content-center">
                <img src="assets/image/doctor2.jpg" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h4>Dr. Siti Rahmawati</h4>
                <p>Ahli Gizi</p>
              </div>
              <div class="flip-card-back d-flex flex-column align-items-center justify-content-center">
                <h5>Profil</h5>
                <p>Memastikan produk sesuai kebutuhan gizi.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Row kedua -->
      <div class="row justify-content-center">
        <div class="col-md-5 mb-4">
          <div class="flip-card" onclick="this.classList.toggle('flipped')">
            <div class="flip-card-inner">
              <div class="flip-card-front d-flex flex-column align-items-center justify-content-center">
                <img src="assets/image/doctor3.jpg" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h4>Dr. Budi Santoso</h4>
                <p>Dokter Umum</p>
              </div>
              <div class="flip-card-back d-flex flex-column align-items-center justify-content-center">
                <h5>Profil</h5>
                <p>Verifikasi keamanan & kualitas produk kesehatan.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 mb-4">
          <div class="flip-card" onclick="this.classList.toggle('flipped')">
            <div class="flip-card-inner">
              <div class="flip-card-front d-flex flex-column align-items-center justify-content-center">
                <img src="assets/image/doctor4.jpg" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h4>Dr. Clara Wijaya</h4>
                <p>Spesialis Kesehatan Masyarakat</p>
              </div>
              <div class="flip-card-back d-flex flex-column align-items-center justify-content-center">
                <h5>Profil</h5>
                <p>Fokus pada produk ramah lingkungan.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Partners -->
  <section id="partners" class="container py-5 text-center">
    <h2 class="display-5 fw-bold text-primary mb-4">Our Partners</h2>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-5">
      <img src="assets/image/partner1.png" alt="Partner 1" class="img-fluid" style="max-height:80px;">
      <img src="assets/image/partner2.png" alt="Partner 2" class="img-fluid" style="max-height:80px;">
      <img src="assets/image/partner3.png" alt="Partner 3" class="img-fluid" style="max-height:80px;">
    </div>
  </section>

  <?php include('footer.php'); ?>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
