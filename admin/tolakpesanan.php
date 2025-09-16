<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pesanan = intval($_GET['id']);

    // update status pesanan
    $update = mysqli_query($conn, "UPDATE pesanan SET status_pesanan='Ditolak' WHERE id_pesanan='$id_pesanan'");

    if ($update) {
        echo "<script>alert('Pesanan ditolak.');window.location='konfirmasi.php';</script>";
    } else {
        echo "<script>alert('Gagal update status pesanan.');window.location='konfirmasi.php';</script>";
    }
}
