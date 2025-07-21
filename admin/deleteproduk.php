<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query untuk menghapus produk
    $querydeleteproduk = mysqli_query($conn, "DELETE FROM produk WHERE id = $id");

    // Cek apakah query berhasil
    if ($querydeleteproduk) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location.href='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk.'); window.location.href='produk.php';</script>";
    }
} else {
    echo "<script>alert('ID produk tidak ditemukan.'); window.location.href='produk.php';</script>";
}
?>


