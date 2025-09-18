<?php 
session_start();
include '../koneksi.php';

// Hitung total customer
$totalcustomer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) AS totalpengguna FROM pendaftar WHERE role='member'"));
$showtotal = $totalcustomer['totalpengguna'];

// Hitung total kategori
$totalkategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id_kategori) AS totalkategori FROM kategori"));
$showkategori = $totalkategori['totalkategori'];

// Hitung total produk
$totalproduk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) AS totalproduk FROM produk"));
$showproduk = $totalproduk['totalproduk'];

// Hitung total pesanan
$totalpesanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id_pesanan) AS totalpesanan FROM pesanan"));
$showpesanan = $totalpesanan['totalpesanan'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Admin Panel</title>

  <!-- Fonts & Styles -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-text mx-1">Dashboard Admin</div>
      </a>
      <hr class="sidebar-divider my-0" />
      
      <!-- Menu -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><span>Beranda</span></a>
      </li>
      <hr class="sidebar-divider" />
      <div class="sidebar-heading">Menu</div>

      <li class="nav-item"><a class="nav-link" href="customer.php"><span>Customer</span></a></li>
      <li class="nav-item"><a class="nav-link" href="produk.php"><span>Produk</span></a></li>
      <li class="nav-item"><a class="nav-link" href="konfirmasi.php"><span>Konfirmasi Pesanan</span></a></li>

      <hr class="sidebar-divider d-none d-md-block" />
    </ul>
    <!-- End Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" role="button">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?>
                </span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" />
              </a>
            </li>
          </ul>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Halo, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?></h1>
          </div>

          <div class="row">
            <!-- Card Customer -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="customer.php" style="text-decoration:none">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Total Customer
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $showtotal ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Card Kategori -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="produk.php" style="text-decoration:none">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Kategori Produk
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $showkategori ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-syringe fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Card Produk -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="produk.php" style="text-decoration:none">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                          Total Produk
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $showproduk ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Card Pesanan -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="konfirmasi.php" style="text-decoration:none">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                          Pesanan Masuk
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $showpesanan ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
