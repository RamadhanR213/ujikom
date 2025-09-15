<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['log'])) {
    echo json_encode(["status" => "error", "message" => "Login dulu"]);
    exit;
}

$user_id = $_SESSION['id'];
$product_id = intval($_GET['p']);

if ($product_id > 0) {
    $cekCart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
    if (mysqli_num_rows($cekCart) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id','$product_id',1)");
    }
    echo json_encode(["status" => "success", "message" => "Produk ditambahkan ke keranjang"]);
} else {
    echo json_encode(["status" => "error", "message" => "Produk tidak valid"]);
}
