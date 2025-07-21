<?php
session_start();
include 'koneksi.php';

$id = $_GET['p'];
$queryProduk = mysqli_query($conn, "select a.*, b.nama_kategori AS nama_kategori from produk a join kategori b on a.id_kategori=b.id_kategori where a.id='$id'");
$produk = mysqli_fetch_array($queryProduk);




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
                            <a class="nav-link" href="index.php">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Belanja</a>
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

    <div class="container-fluid py-5 mt-5">
        <div class="container mb-3">
            <a href="belanja.php" class="btn btn-primary"><i class="fa-solid fa-chevron-left mx-2"></i>Kembali</a>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-md-5">
                    <div class="card">
                        <img src="assets/image/<?php echo $produk['foto']  ?>" class="w-100">
                    </div>
                </div>
                <div class="col-md-6 offset-md-1 ">
                    <div class="card p-5">
                        <h3><?php echo $produk['nama'] ?></h3>
                        <p class="fs-5">
                            <?php echo $produk['detail'] ?>
                        </p>
                        <p class="harga fs-5">
                            Rp.<?php echo number_format($produk['harga'], 0, ',', '.')  ?>
                        </p>
                        <p class="">
                            Ketersediaan Stok : <b> <?php echo $produk['stok'] ?></b>
                        </p>
                        <p>
                            Kategori Produk : <b><?php echo $produk['nama_kategori'] ?></b>
                        </p>
                    </div>
                    <?php if ($produk['stok'] == 'habis') { ?>
                        <div class="text-center my-3">
                            <a href="" class="btn btn-secondary px-5">Stok Habis</a>
                        </div>
                    <?php
                    } else { ?>
                        <div class="text-center my-3">
                            <a href="addcart.php?p=<?php echo $produk['id'] ?>" class="btn btn-primary px-5">Beli Langsung</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>


    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>


</body>

</html>