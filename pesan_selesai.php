<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['log']) || $_SESSION['role'] != 'member') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_pesanan = intval($_GET['id']);
    $user_id = $_SESSION['id'];

    // Pastikan pesanan milik user yang login
    $cek = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan' AND id_pengguna='$user_id'");
    if (mysqli_num_rows($cek) > 0) {
        // Update status menjadi selesai
        $update = mysqli_query($conn, "UPDATE pesanan SET status_pesanan='Selesai' WHERE id_pesanan='$id_pesanan'");

        if ($update) {
            echo "<script>alert('Pesanan berhasil diselesaikan! Terima kasih sudah berbelanja.'); window.location='cart.php';</script>";
        } else {
            echo "<script>alert('Gagal update status pesanan!'); window.location='cart.php';</script>";
        }
    } else {
        echo "<script>alert('Pesanan tidak valid!'); window.location='cart.php';</script>";
    }
} else {
    header("Location: cart.php");
    exit;
}
