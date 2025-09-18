<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include "koneksi.php";
include "phpmailer/src/PHPMailer.php";
include "phpmailer/src/Exception.php";
include "phpmailer/src/SMTP.php";
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$id = intval($_GET['id']);

// Ambil data pesanan (pakai kolom `pembayaran` sesuai DB asli)
$ambilPesanan = $conn->query("
    SELECT p.id_pesanan, p.tanggal, p.total, p.status, p.pembayaran,
           u.username AS nama_pembeli, u.address, u.contact, u.email
    FROM pesanan p
    JOIN pendaftar u ON p.id_pengguna = u.id
    WHERE p.id_pesanan = $id
")->fetch_assoc();

// Ambil list produk pesanan
$queryProduk = $conn->query("
    SELECT pr.nama, pr.harga, pp.jumlah
    FROM produk_pesanan pp
    JOIN produk pr ON pp.id_produk = pr.id
    WHERE pp.id_pesanan = $id
");

$total = 0;
$produkList = [];
while ($produk = $queryProduk->fetch_assoc()) {
    $subtotal = $produk['harga'] * $produk['jumlah'];
    $produk['subtotal'] = $subtotal;
    $total += $subtotal;
    $produkList[] = $produk;
}
$ppn = $total * 0.05;
$grandTotal = $total + $ppn;

// ---------------- Buat PDF ----------------
$dompdf = new Dompdf();
$htmlPDF = '
<div style="font-family:sans-serif;">
    <div style="text-align:center;">
        <h2>MedShop</h2>
        <h4>Nota Pembelian</h4>
    </div>
    <hr>
    <div style="display:flex; justify-content:space-between;">
        <div>
            <strong>User ID:</strong> '.$ambilPesanan['id_pesanan'].'<br>
            <strong>Nama Pembeli:</strong> '.$ambilPesanan['nama_pembeli'].'<br>
            <strong>Alamat:</strong> '.$ambilPesanan['address'].'<br>
            <strong>Nomor HP:</strong> '.$ambilPesanan['contact'].'<br>
        </div>
        <div style="text-align:right;">
            <strong>Tanggal Pembelian:</strong> '.$ambilPesanan['tanggal'].'<br>
            <strong>Pembayaran:</strong> '.$ambilPesanan['pembayaran'].'
        </div>
    </div>
    <br>
    <table border="1" width="100%" cellpadding="5" cellspacing="0">
        <tr><th>No</th><th>Nama Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>';
$no=1;
foreach($produkList as $p){
    $htmlPDF .= '<tr>
        <td>'.$no++.'</td>
        <td>'.$p['nama'].'</td>
        <td>Rp '.number_format($p['harga'],0,',','.').'</td>
        <td>'.$p['jumlah'].'</td>
        <td>Rp '.number_format($p['subtotal'],0,',','.').'</td>
    </tr>';
}
$htmlPDF .= '</table>
    <br>
    <p style="text-align:right;">
        Total: Rp '.number_format($total,0,',','.').'<br>
        PPN 5%: Rp '.number_format($ppn,0,',','.').'<br>
        <strong>Grand Total: Rp '.number_format($grandTotal,0,',','.').'</strong>
    </p>
</div>';

$dompdf->loadHtml($htmlPDF);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$pdfOutput = $dompdf->output();

// ---------------- Kirim Email ----------------
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'ssl://smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'healthshoprey@gmail.com';
    $mail->Password   = 'rqyb udim megp opsz';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('healthshoprey@gmail.com', 'MedShop Admin');
    $mail->addAddress($ambilPesanan['email'], $ambilPesanan['nama_pembeli']);
    $mail->isHTML(true);
    $mail->Subject = 'Bukti Transaksi MedShop - ID Pesanan '.$id;
    $mail->Body    = 'Halo '.$ambilPesanan['nama_pembeli'].',<br>Berikut bukti transaksi Anda. Silakan download PDF terlampir.<br><br>Terima kasih telah berbelanja di MedShop!';
    $mail->addStringAttachment($pdfOutput, 'Nota_MedShop_'.$id.'.pdf');
    $mail->send();
} catch (Exception $e) {}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nota MedShop</title>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<style>
.card {border:1px solid #ccc; padding:20px; margin-top:20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);}
.table th, .table td {vertical-align: middle; border:1px solid #ccc; text-align:center;}
.table th {background-color:#cfe2ff;}
.text-end {text-align:right;}
</style>
</head>
<body>
<div class="container mt-4">
    <div class="text-center mb-4">
        <h2>MedShop</h2>
        <p>Nota Pembelian</p>
    </div>

    <div class="card">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>User ID:</strong> <?= $id ?><br>
                <strong>Nama Pembeli:</strong> <?= $ambilPesanan['nama_pembeli'] ?><br>
                <strong>Alamat:</strong> <?= $ambilPesanan['address'] ?><br>
                <strong>Nomor HP:</strong> <?= $ambilPesanan['contact'] ?><br>
            </div>
            <div class="col-md-6 text-end">
                <strong>Tanggal Pembelian:</strong> <?= $ambilPesanan['tanggal'] ?><br>
                <strong>Metode Pembayaran:</strong> <?= $ambilPesanan['pembayaran'] ?><br>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($produkList as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p['nama'] ?></td>
                    <td><?= 'Rp '.number_format($p['harga'],0,',','.') ?></td>
                    <td><?= $p['jumlah'] ?></td>
                    <td><?= 'Rp '.number_format($p['subtotal'],0,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h5 class="text-end">Total: <?= 'Rp '.number_format($total,0,',','.') ?></h5>
        <h5 class="text-end">PPN 5%: <?= 'Rp '.number_format($ppn,0,',','.') ?></h5>
        <h4 class="text-end">Grand Total: <?= 'Rp '.number_format($grandTotal,0,',','.') ?></h4>

        <div class="text-center mt-3">
            <a href="unduhbukti.php?id=<?= $id ?>" class="btn btn-success">Download PDF</a>
        </div>
    </div>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
