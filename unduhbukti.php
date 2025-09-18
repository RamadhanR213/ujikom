<?php
session_start();
include 'koneksi.php';
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

if (!isset($_SESSION['log'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("ID Pesanan tidak ditemukan.");
}

$id = intval($_GET['id']);

// Ambil data pesanan
$ambilPesanan = $conn->query("
    SELECT p.id_pesanan, p.tanggal, p.total, p.status_pesanan, p.pembayaran,
           u.username AS nama_pembeli, u.address, u.contact, u.email
    FROM pesanan p
    JOIN pendaftar u ON p.id_pengguna = u.id
    WHERE p.id_pesanan = $id
")->fetch_assoc();

if (!$ambilPesanan) {
    die("Pesanan tidak ditemukan.");
}

// Ambil produk yang dipesan
$produkPesanan = $conn->query("
    SELECT pr.nama, pr.harga, pp.jumlah
    FROM produk_pesanan pp
    JOIN produk pr ON pp.id_produk = pr.id
    WHERE pp.id_pesanan = $id
");

$html = "
<h2 style='text-align:center;'>Bukti Pesanan</h2>
<p><strong>No. Pesanan:</strong> {$ambilPesanan['id_pesanan']}</p>
<p><strong>Tanggal:</strong> {$ambilPesanan['tanggal']}</p>
<p><strong>Pembeli:</strong> {$ambilPesanan['nama_pembeli']}</p>
<p><strong>Email:</strong> {$ambilPesanan['email']}</p>
<p><strong>Alamat:</strong> {$ambilPesanan['address']}</p>
<p><strong>Kontak:</strong> {$ambilPesanan['contact']}</p>
<p><strong>Metode Pembayaran:</strong> {$ambilPesanan['pembayaran']}</p>
<br>
<table border='1' cellspacing='0' cellpadding='5' width='100%'>
<tr>
    <th>Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Total</th>
</tr>
";

$total = 0;
while ($row = $produkPesanan->fetch_assoc()) {
    $subtotal = $row['harga'] * $row['jumlah'];
    $total += $subtotal;
    $html .= "
    <tr>
        <td>{$row['nama']}</td>
        <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
        <td>{$row['jumlah']}</td>
        <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
    </tr>";
}

$ppn = $total * 0.05;
$grandTotal = $total + $ppn;

$html .= "
<tr>
    <td colspan='3' align='right'><strong>Total</strong></td>
    <td><strong>Rp " . number_format($total, 0, ',', '.') . "</strong></td>
</tr>
<tr>
    <td colspan='3' align='right'>PPN 5%</td>
    <td>Rp " . number_format($ppn, 0, ',', '.') . "</td>
</tr>
<tr>
    <td colspan='3' align='right'><strong>Grand Total</strong></td>
    <td><strong>Rp " . number_format($grandTotal, 0, ',', '.') . "</strong></td>
</tr>
</table>
<p style='margin-top:30px; text-align:center;'>Terima kasih telah berbelanja di MedShop!</p>
";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Tampilkan langsung di browser
$dompdf->stream("bukti_pesanan_{$ambilPesanan['id_pesanan']}.pdf", array("Attachment" => false));
exit;
