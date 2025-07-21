<?php
session_start();
include '../koneksi.php';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query untuk menghapus produk
    $updatestatus = mysqli_query($conn, "UPDATE pesanan set status='Ditolak' WHERE id_pesanan = $id");

    // Cek apakah query berhasil
    if ($updatestatus) {
        echo "<script>alert('Pesanan berhasil diupdate!'); window.location.href='konfirmasi.php';</script>";
    } else {
        echo "<script>alert('Gagal update pesanan.'); window.location.href='konfirmasi.php';</script>";
    }
} else {
    echo "<script>alert('ID pesanan tidak ditemukan.'); window.location.href='konfirmasi.php';</script>";
}
?>


