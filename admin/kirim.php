<?php
session_start();
include '../koneksi.php';

// Pastikan hanya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_pesanan = intval($_GET['id']);

    // Update status pesanan menjadi 'Dikirim'
    $update = mysqli_query($conn, "UPDATE pesanan SET status_pesanan='Dikirim' WHERE id_pesanan='$id_pesanan'");

    if ($update) {
        echo "<script>alert('Pesanan berhasil dikirim!'); window.location='konfirmasi.php';</script>";
    } else {
        echo "<script>alert('Gagal update status pesanan!'); window.location='konfirmasi.php';</script>";
    }
} else {
    header("Location: konfirmasi.php");
    exit;
}
