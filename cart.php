<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['log'])) {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
    exit; // Pastikan untuk menghentikan eksekusi skrip setelah redirect
}

if (!empty($_GET['p'])) {
    $id = $_GET['p'];
} else {
    $id = 0;
}

if (isset($_SESSION['cart'][$id])) {
} else {
    $_SESSION['cart'][$id] = 1;
}

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

$queryListUser = mysqli_query($conn, "SELECT * from pendaftar where id=$_SESSION[id]");



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
                            <a class="nav-link" href="belanja.php">Belanja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="cart.php?p=0">Keranjang</a>
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
            <div class="card p-5">
                <h5 class="border p-3 text-center">Keranjang Belanja</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Sub Total Harga</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        $totalharga = 0 ?>
                        <?php foreach ($_SESSION['cart'] as $id => $jumlah): ?>
                            <?php
                            if (!empty($id)) {
                                $queryListProduk = $conn->query("SELECT * from produk where id=$id");

                                $data = $queryListProduk->fetch_assoc();

                                if (!empty($jumlah)) {
                                    $subharga = $data['harga'] * $jumlah;
                                    $totalharga = $totalharga + $subharga;
                                }
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo 'Rp.', number_format($data['harga'], 0, ',', '.') ?></td>
                                    <td><?php echo $jumlah ?></td>
                                    <td><?php echo 'Rp.', number_format($subharga, 0, ',', '.') ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="addcart.php?p=<?php echo $data['id'] ?>"><i class="fa fa-plus"></i></a>
                                        <a class="btn btn-primary" href="mincart.php?p=<?php echo $data['id'] ?>"><i class="fa fa-minus"></i></a>
                                    </td>
                                </tr>

                            <?php $no++;
                            }
                            ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <tfoot>
                    <h6>Total Harga : <span class="harga"><?php echo 'Rp.', number_format($totalharga, 0, ',', '.') ?></span></h6>

                </tfoot>

                <div class="mt-5">
                    <h6>Data Pembeli</h6>
                    <form action="" method="post">
                        <div class="row">
                            <?php $dataUser = mysqli_fetch_array($queryListUser) ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" readonly class="form-control text-center" value="<?php echo $dataUser['username'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" readonly class="form-control text-center" value="<?php echo $dataUser['email'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" readonly class="form-control text-center" value="<?php echo $dataUser['address'] ?>, <?php echo $dataUser['city'] ?> ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" readonly class="form-control text-center" value="<?php echo $dataUser['contact'] ?>">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group text-center mt-5">
                                    Metode Pembayaran
                                    <select name="pembayaran" id="pembayaran">
                                        <option value="Transfer">Transfer - a/n Muhammad Reyhan No. Rekening 123412987</option>
                                        <option value="COD">Bayar Di Tempat</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <button class="container btn btn-primary px-3 py-2 mt-3 " name="checkout">Checkout</button>
                    </form>

                </div>

            </div>


        </div>
    </div>
    <?php
    if (isset($_POST['checkout'])) {
        $id_pengguna = $_SESSION['id'];
        $tanggal = date("d-m-Y");
        $pembayaran = htmlspecialchars($_POST['pembayaran']);
        $totalhargapesanan = $totalharga + 0.05 * $totalharga; //admin 5%
        $conn->query("INSERT INTO pesanan (id_pengguna, tanggal, total, pembayaran) VALUES ('$id_pengguna', '$tanggal', '$totalhargapesanan', '$pembayaran')");

        $id_pembelianbaru = $conn->insert_id;

        foreach ($_SESSION['cart'] as $id_produk => $jumlah) {
            if ($id_produk != 0) {
                $conn->query("INSERT INTO produk_pesanan (id_pesanan, id_produk, jumlah) VALUES ('$id_pembelianbaru', '$id_produk', '$jumlah')");
                echo "<script>alert('Pembelian Sukses, Dimohon untuk cek email untuk informasi update status pesanan.')</script>";
                echo "<script>location='unduhbukti.php?id=$id_pembelianbaru'</script>";
            }
        }
    }
    ?>









    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>