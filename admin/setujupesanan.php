<?php
session_start();
include '../koneksi.php';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query untuk menghapus produk
    $updatestatus = mysqli_query($conn, "UPDATE pesanan set status='Disetujui' WHERE id_pesanan = $id");

    // Cek apakah query berhasil
    if ($updatestatus) {
        echo "<script>alert('Pesanan berhasil diupdate!'); window.location.href='konfirmasi.php';
         window.location.href = 'https://wa.me/+6281240277417';</script>
       ";
    } else {
        echo "<script>alert('Gagal update pesanan.'); window.location.href='konfirmasi.php';</script>";
    }
} else {
    echo "<script>alert('ID pesanan tidak ditemukan.'); window.location.href='konfirmasi.php';</script>";
}
