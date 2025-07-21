<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "phpmailer/src/PHPMailer.php";
include "phpmailer/src/Exception.php";
include "phpmailer/src/POP3.php";
include "phpmailer/src/SMTP.php";

$mail = new PHPMailer(true);

require_once 'dompdf/autoload.inc.php';
include 'koneksi.php';
$id = $_GET['id'];

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$query = mysqli_query($conn, "SELECT * FROM pesanan 
    JOIN produk_pesanan ON pesanan.id_pesanan = produk_pesanan.id_pesanan 
    JOIN produk ON produk_pesanan.id_produk = produk.id JOIN pendaftar ON pesanan.id_pengguna = pendaftar.id
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
    $email = $row['email'];
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
</tr>
<hr>
<hr>
<p><b>Note : </b><br>
Mohon simpan nota ini, tunggu informasi lebih lanjut<br>mengenai update pesanan dan akan dihubungi admin melalui Whatsapp.
</p>
";

$htmlContent .= "</table>";

$dompdf->loadHtml($htmlContent);
$dompdf->setPaper('A3', 'portrait');
$dompdf->render();
$dompdf->stream('document', array('Attachment' => 0));




//PHPMailer

$mail->SMTPDebug = 0;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'ssl://smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'healthshoprey@gmail.com';                     //SMTP username
$mail->Password   = 'rqyb udim megp opsz';                               //SMTP password
$mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
$mail->Port       = 465;

//Pengirim
$mail->From = $mail->Username;
$mail->FromName = "Admin Health Shop";

//Penerima
$mail->setFrom($email, "Health Shop");
$mail->addAddress($email);
$mail->isHTML(true);
$mail->Subject = "Bukti Transaksi Health Shop";
$mail->Body = $htmlContent;

$mail->send();

if ($mail->send()) {
    echo 'Email berhasil dikirim';
    echo '<href="index.php">Kembali ke menu toko';
}
