<?php
$servername =  "localhost";
$database =  "oss_ujikom";
$username =  "root";
$password =  "";

$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Koneksi Gagal : " . mysqli_connect());
} else {

    $timeout_duration = 600;

    // Cek apakah 'last_activity' sudah ada di $_SESSION
    if (isset($_SESSION['last_activity'])) {
        // Hitung selisih waktu antara sekarang dan terakhir kali aktivitas
        $elapsed_time = time() - $_SESSION['last_activity'];

        // Jika selisih waktu lebih besar dari batas waktu yang ditentukan, sesi diakhiri
        if ($elapsed_time > $timeout_duration) {
            // Akhiri sesi (logout otomatis)
            session_start();
            session_destroy();
            header("location:../toko-alat-kesehatan/login.php");
        }
    }

    // Perbarui waktu aktivitas terakhir
    $_SESSION['last_activity'] = time();
}
