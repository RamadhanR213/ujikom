<?php
session_start();
include 'koneksi.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "phpmailer/src/PHPMailer.php";
include "phpmailer/src/Exception.php";
include "phpmailer/src/SMTP.php";

$user_id = $_SESSION['id'] ?? 0;
if (!$user_id) {
    header('Location: login.php'); exit;
}

// ==================== PROSES CHECKOUT ====================
if (isset($_POST['checkout'])) {
    $tanggal = date("Y-m-d");
    $pembayaran = mysqli_real_escape_string($conn, $_POST['pembayaran']);
    $totalharga = 0;

    // ambil keranjang
    $cartItems = mysqli_query($conn, "SELECT c.*, p.harga 
                                      FROM cart c 
                                      JOIN produk p ON c.product_id=p.id 
                                      WHERE c.user_id='$user_id'");

    while ($item = mysqli_fetch_assoc($cartItems)) {
        $totalharga += $item['harga'] * $item['quantity'];
    }

    if ($totalharga == 0) {
        header("Location: cart.php"); exit;
    }

    $totalhargapesanan = $totalharga * 1.05; // PPN 5%

    // simpan pesanan
    $conn->query("INSERT INTO pesanan (id_pengguna, tanggal, total, pembayaran, status_pesanan) 
                  VALUES ('$user_id', '$tanggal', '$totalhargapesanan', '$pembayaran', 'Menunggu Konfirmasi')");
    $id_pesanan = $conn->insert_id;

    // simpan detail produk
    $cartItems2 = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
    while ($item = mysqli_fetch_assoc($cartItems2)) {
        $conn->query("INSERT INTO produk_pesanan (id_pesanan, id_produk, jumlah) 
                      VALUES ('$id_pesanan', '".$item['product_id']."', '".$item['quantity']."')");
    }

    // hapus cart
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");
    unset($_SESSION['cart']);

    // ================= KIRIM EMAIL =================
    $ambilUser = mysqli_fetch_assoc(mysqli_query($conn,"SELECT email, username FROM pendaftar WHERE id='$user_id'"));
    $emailUser = $ambilUser['email'];
    $namaUser = $ambilUser['username'];

    // Buat isi email
    $htmlEmail = '<h2>MedShop</h2><p>Terima kasih '.$namaUser.' telah berbelanja.</p>';
    $htmlEmail .= '<p>Silakan cek nota pembelian <a href="'.$_SERVER['HTTP_HOST'].'/nota.php?id='.$id_pesanan.'">di sini</a>.</p>';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'ssl://smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'healthshoprey@gmail.com';
        $mail->Password = 'rqyb udim megp opsz';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('healthshoprey@gmail.com', 'Admin MedShop');
        $mail->addAddress($emailUser, $namaUser);
        $mail->isHTML(true);
        $mail->Subject = "Bukti Transaksi MedShop";
        $mail->Body = $htmlEmail;
        $mail->send();
    } catch (Exception $e) {
        // email gagal, tetap redirect
    }

    // redirect ke nota
    header("Location: nota.php?id=$id_pesanan");
    exit;
}

// Tambah produk ke cart
if (!empty($_GET['p'])) {
    $product_id = intval($_GET['p']);
    if ($product_id > 0) {
        $cekCart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
        if (mysqli_num_rows($cekCart) > 0) {
            mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'");
        } else {
            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id','$product_id',1)");
        }
    }
}

// Ambil data user
$queryListUser = mysqli_query($conn, "SELECT * FROM pendaftar WHERE id='$user_id'");

// Ambil keranjang
$queryCart = mysqli_query($conn, "SELECT c.id, c.quantity, p.nama, p.harga, p.id as produk_id
                                  FROM cart c
                                  JOIN produk p ON c.product_id = p.id
                                  WHERE c.user_id='$user_id'");

// User konfirmasi pesanan diterima
if (isset($_GET['terima'])) {
    $id_pesanan = intval($_GET['terima']);
    mysqli_query($conn, "UPDATE pesanan SET status_pesanan='Selesai' 
                         WHERE id_pesanan='$id_pesanan' AND id_pengguna='$user_id'");
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Keranjang - MedShop</title>
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
          <li class="nav-item"><a class="nav-link" href="belanja.php">Belanja</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Keranjang</a></li>
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

  <div class="container py-5">
    <!-- Keranjang -->
    <div class="card shadow p-4">
        <h4 class="text-center mb-4">Keranjang Belanja</h4>
        <table class="table table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                $totalharga = 0;
                if (mysqli_num_rows($queryCart) == 0) {
                    echo "<tr><td colspan='6' class='text-center'>Keranjang kosong</td></tr>";
                } else {
                    while ($data = mysqli_fetch_assoc($queryCart)) {
                        $subharga = $data['harga'] * $data['quantity'];
                        $totalharga += $subharga;
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td>Rp <?= number_format($data['harga'],0,',','.') ?></td>
                    <td><?= $data['quantity'] ?></td>
                    <td>Rp <?= number_format($subharga,0,',','.') ?></td>
                    <td>
                        <a class="btn btn-sm btn-success" href="updatecart.php?action=add&id=<?= $data['produk_id'] ?>"><i class="fa fa-plus"></i></a>
                        <a class="btn btn-sm btn-warning" href="updatecart.php?action=minus&id=<?= $data['produk_id'] ?>"><i class="fa fa-minus"></i></a>
                        <a class="btn btn-sm btn-danger" href="updatecart.php?action=delete&id=<?= $data['produk_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php } } ?>
            </tbody>
        </table>
        <?php
            $ppn = $totalharga * 0.05;
            $grandTotal = $totalharga + $ppn;
            ?>
            <div class="text-end">
                <h5>Total Harga: Rp <?= number_format($totalharga,0,',','.') ?></h5>
                <h5>PPN 5%: Rp <?= number_format($ppn,0,',','.') ?></h5>
                <h4>Grand Total: Rp <?= number_format($grandTotal,0,',','.') ?></h4>
            </div>

        <!-- Data Pembeli -->
        <hr>
        <h5 class="mt-4">Data Pembeli</h5>
        <form method="post">
            <div class="row">
                <?php $dataUser = mysqli_fetch_array($queryListUser); ?>
                <div class="col-md-3"><input type="text" readonly class="form-control" value="<?= $dataUser['username'] ?>"></div>
                <div class="col-md-3"><input type="text" readonly class="form-control" value="<?= $dataUser['email'] ?>"></div>
                <div class="col-md-3"><input type="text" readonly class="form-control" value="<?= $dataUser['address'].', '.$dataUser['city'] ?>"></div>
                <div class="col-md-3"><input type="text" readonly class="form-control" value="<?= $dataUser['contact'] ?>"></div>
            </div>
            <div class="mt-4">
                <label>Metode Pembayaran</label>
                <select name="pembayaran" class="form-control" required>
                    <?php
                    $metodeQ = mysqli_query($conn, "SELECT * FROM pembayaran WHERE user_id='$user_id'");
                    if (mysqli_num_rows($metodeQ) > 0) {
                        while ($m = mysqli_fetch_assoc($metodeQ)) {
                            echo '<option value="'.$m['metode'].' - '.$m['nomor'].' - a/n '.$m['atas_nama'].'">'.
                                 $m['metode'].' - '.$m['nomor'].' - a/n '.$m['atas_nama'].'</option>';
                        }
                    } else {
                        echo '<option value="COD">Bayar di Tempat</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="checkout" 
                    class="btn btn-primary w-100 mt-3" 
                    <?= ($totalharga == 0 ? 'disabled' : '') ?>>
                Checkout
            </button>
        </form>

        <!-- Riwayat Pesanan -->
<table class="table table-bordered table-striped">
    <thead class="table-secondary text-center align-middle">
        <tr>
            <th>No.</th>
            <th>ID Pesanan</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Pembayaran</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody class="text-center align-middle">
        <?php
        $riwayatQ = mysqli_query($conn, "
            SELECT p.id_pesanan, p.tanggal, p.total, p.status_pesanan, p.pembayaran
            FROM pesanan p
            WHERE p.id_pengguna='$user_id'
            ORDER BY p.id_pesanan DESC
        ");

        if (mysqli_num_rows($riwayatQ) == 0) {
            echo "<tr><td colspan='7' class='text-center'>Belum ada pesanan</td></tr>";
        } else {
            $no=1;
            while ($r = mysqli_fetch_assoc($riwayatQ)) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$r['id_pesanan']}</td>
                        <td>{$r['tanggal']}</td>
                        <td>Rp ".number_format($r['total'],0,',','.')."</td>
                        <td>{$r['pembayaran']}</td>
                        <td><span class='badge bg-".
                            ($r['status_pesanan']=='Menunggu Konfirmasi'?'secondary':
                            ($r['status_pesanan']=='Sedang diproses'?'warning':
                            ($r['status_pesanan']=='Ditolak'?'danger':
                            ($r['status_pesanan']=='Dikirim'?'info':
                            ($r['status_pesanan']=='Selesai'?'success':'dark'))))).
                        "'>{$r['status_pesanan']}</span></td>
                        <td>";
                if ($r['status_pesanan']=='Dikirim') {
                    echo "<a href='cart.php?terima={$r['id_pesanan']}' class='btn btn-success btn-sm'>Pesanan Diterima</a>";
                }
                if ($r['status_pesanan']=='Selesai' || $r['status_pesanan']=='Ditolak') {
                    echo " <button class='btn btn-danger btn-sm btn-hapus-row'>Hapus</button>";
                }
                echo "</td></tr>";
                $no++;
            }
        }
        ?>
    </tbody>
</table>


<script>
// JavaScript untuk menghapus row di tampilan saja
document.addEventListener('DOMContentLoaded', function(){
    const buttons = document.querySelectorAll('.btn-hapus-row');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(){
            if(confirm('Apakah Anda yakin ingin menghapus pesanan dari tampilan?')){
                const row = this.closest('tr');
                row.remove();
            }
        });
    });
});
</script>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
