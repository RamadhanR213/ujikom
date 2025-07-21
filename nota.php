<?php
include "koneksi.php";
$id = $_GET['id']
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
    <?php
    $ambil = $conn->query("SELECT * FROM pesanan JOIN pendaftar ON pesanan.id_pengguna = pendaftar.id WHERE pesanan.id_pesanan = $id")

    ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Sub Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $totalharga = 0 ?>
            <?php

            $queryListProduk = $conn->query("SELECT * from produk_pesanan JOIN produk on produk_pesanan.id_produk = produk.id where produk_pesanan.id_pesanan = '$_GET[id]'");
            $data = $queryListProduk->fetch_assoc();


            $subharga = $data['harga'] * $data['jumlah'];
            $totalharga = $totalharga + $subharga;


            while ($data = $queryListProduk->fetch_assoc()) {
            ?>

                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo 'Rp.', number_format($data['harga'], 0, ',', '.') ?></td>
                    <td><?php echo $data['jumlah'] ?></td>
                    <td><?php echo 'Rp.', number_format($subharga, 0, ',', '.') ?></td>
                </tr>

            <?php $no++;
            }
            ?>
        </tbody>
    </table>
    <tfoot>
        <h6>Total Harga : <span class="harga"><?php echo 'Rp.', number_format($totalharga, 0, ',', '.') ?></span></h6>
    </tfoot>


    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>