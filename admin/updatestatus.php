<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id_pesanan = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    mysqli_query($conn, "UPDATE pesanan SET status_pesanan='$status' WHERE id_pesanan='$id_pesanan'");
}

// kembali ke konfirmasi admin
header("Location: konfirmasi.php");
exit;
