<?php
session_start();
include 'koneksi.php';

$querykategori = mysqli_query($conn, "SELECT * from kategori");

if (isset($_GET['kategori'])) {
  $queryListProduk = mysqli_query($conn, "SELECT * from produk where id_kategori='$_GET[kategori]'");
} else {
  $queryListProduk = mysqli_query($conn, "SELECT * from produk");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MedShop</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
  <link rel="stylesheet" href="assets/style.css" />
</head>
<style>
   .navbar {
      background: linear-gradient(90deg, #0d6efd, #084298);
    }
    .navbar-brand, .nav-link, .btn {
      font-weight: 500;
    }
</style>

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
          <li class="nav-item"><a class="nav-link active" href="#">Belanja</a></li>
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

<section id="produk">
  <div class="container-fluid py-5">
    <div class="container text-center">
      <div class="mb-5">
        <h3>Produk</h3>
      </div>

      <div class="row">
        <div class="d-flex dropdown mb-3">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" name="kategori" data-bs-toggle="dropdown" aria-expanded="false">
            Kategori Produk
          </a>

          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="belanja.php">
                Semua Kategori
              </a>
            </li>
            <?php
            while ($data = mysqli_fetch_array($querykategori)) {
            ?>
              <li>
                <a class="dropdown-item" href="belanja.php?kategori=<?php echo $data['id_kategori'] ?>">
                  <?php echo $data['nama_kategori'] ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
          <?php
          while ($data = mysqli_fetch_array($queryListProduk)) {
          ?>
            <div class="col">
              <div class="card h-100">
                <div class="cardimg">
                  <img src="assets/image/<?php echo $data['foto'] ?>" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $data['nama'] ?></h5>
                  <p class="card-text text-truncate"><?php echo $data['detail'] ?></p>
                  <p class="card-text harga">Rp.<?php echo number_format($data['harga'], 0, ',', '.')  ?></p>
                  <div class="d-flex justify-content-between">
                    <!-- Tombol Info -->
                    <a href="detail.php?p=<?php echo $data['id'] ?>" class="btn btn-info">
                      <i class="fa-solid fa-info"></i>
                    </a>

                    <!-- Tombol Pesan langsung ke cart.php -->
                    <a href="cart.php?p=<?php echo $data['id'] ?>" class="btn btn-primary">Pesan</a>

                    <!-- Tombol Keranjang pakai AJAX -->
                    <?php if ($data['stok'] == 'habis') { ?>
                      <a href="#" class="btn btn-secondary">Stok Habis</a>
                    <?php } else { ?>
                      <button class="btn btn-success add-to-cart" data-id="<?php echo $data['id'] ?>">
                        <i class="fa-solid fa-cart-arrow-down"></i>
                      </button>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require 'footer.php' ?>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".add-to-cart").forEach(btn => {
        btn.addEventListener("click", () => {
            let productId = btn.getAttribute("data-id");

            fetch("addcart.php?p=" + productId)
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        alert("✅ " + data.message);
                    } else {
                        alert("⚠️ " + data.message);
                        if (data.message.includes("Login")) {
                            window.location.href = "login.php";
                        }
                    }
                })
                .catch(err => console.error(err));
        });
    });
});
</script>
</body>
</html>
