<?php 
session_start();
include '../koneksi.php';

// Ambil semua customer (role = member)
$query = mysqli_query($conn, "SELECT id, username, email FROM pendaftar WHERE role='member'");
$jumlahcustomer = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Daftar Customer - Admin Panel</title>

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
      <li class="nav-item">
        <a class="nav-link" href="index.php"><span>Beranda</span></a>
      </li>
      <hr class="sidebar-divider" />
      <div class="sidebar-heading">Menu</div>
      <li class="nav-item active"><a class="nav-link" href="customer.php"><span>Customer</span></a></li>
      <li class="nav-item"><a class="nav-link" href="produk.php"><span>Produk</span></a></li>
      <li class="nav-item"><a class="nav-link" href="konfirmasi.php"><span>Konfirmasi Pesanan</span></a></li>
      <li class="nav-item"><a class="nav-link" href="../index.php"><span>Kembali ke toko</span></a></li>
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
            <h1 class="h3 mb-0 text-gray-800">Daftar Customer</h1>
            <a href="index.php" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
          </div>

          <!-- Tabel Customer -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Total Customer: <?php echo $jumlahcustomer; ?></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-center" width="100%" cellspacing="0">
                  <thead class="table-primary">
                    <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if ($jumlahcustomer == 0) {
                      echo "<tr><td colspan='3'>Belum ada customer</td></tr>";
                    } else {
                      $no = 1;
                      while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>
                                <td>".$no++."</td>
                                <td>".$row['username']."</td>
                                <td>".$row['email']."</td>
                              </tr>";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
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
