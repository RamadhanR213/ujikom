<?php
require_once 'dompdf/autoload.inc.php';
include 'koneksi.php';
$id = $_GET['id'];

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$query = mysqli_query($conn, "SELECT * FROM pesanan 
    JOIN produk_pesanan ON pesanan.id_pesanan = produk_pesanan.id_pesanan 
    JOIN produk ON produk_pesanan.id_produk = produk.id 
    WHERE produk_pesanan.id_pesanan = $id");

$htmlContent = '<center><h4>Bukti Pembelian Alat Kesehatan Health Shop</h4></center><hr/><br/><br/><br/>';
$htmlContent .= '<table border="1" width="100%">
    <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Jumlah</th>
        <th>Harga</th>
    </tr>';

$no = 1;
$total = 0;

while ($row = mysqli_fetch_array($query)) {
    $htmlContent .= "
    <tr>
        <td>" . $no . "</td>
        <td>" . $row['nama'] . "</td>
        <td>" . $row['jumlah'] . "</td>
        <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
    </tr>";
    $total = $row['total']; // Assuming this is from your `pesanan` table
    $no++;
}

$htmlContent .= "<tr>
    <td colspan='3'><strong>Total Harga (+PPN 5%)</strong></td>
    <td><strong>Rp " . number_format($total, 0, ',', '.') . "</strong></td>
</tr>";

$htmlContent .= "</table>";

$dompdf->loadHtml($htmlContent);
$dompdf->setPaper('A3', 'portrait');
$dompdf->render();
$dompdf->stream('document', array('Attachment' => 0));
