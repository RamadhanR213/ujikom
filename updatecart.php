<?php
session_start();
include 'koneksi.php';

// ambil user id dari session (sesuaikan dengan session login kamu)
// biasanya di project-mu session login adalah $_SESSION['id']
if (isset($_SESSION['id'])) {
    $user_id = (int) $_SESSION['id'];
} elseif (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
} else {
    // jika tidak ada session, arahkan ke login
    header("Location: login.php");
    exit;
}

if (!isset($_GET['action']) || !isset($_GET['id'])) {
    header("Location: cart.php");
    exit;
}

$action = $_GET['action'];
$product_id = intval($_GET['id']);
if ($product_id <= 0) {
    header("Location: cart.php");
    exit;
}

// ambil row cart untuk user + product (jika ada)
$cekQ = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");
$exists = mysqli_num_rows($cekQ) > 0;
$item = $exists ? mysqli_fetch_assoc($cekQ) : null;

if ($action === 'add') {
    if ($exists) {
        // update quantity +1
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id");
    } else {
        // insert baru dengan quantity 1
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
    }

} elseif ($action === 'minus') {
    if ($exists) {
        $qty = (int) $item['quantity'];
        if ($qty > 1) {
            mysqli_query($conn, "UPDATE cart SET quantity = quantity - 1 WHERE user_id = $user_id AND product_id = $product_id");
        } else {
            // hapus kalau qty 1
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id");
        }
    }
    // jika tidak exists -> tidak perlu aksi

} elseif ($action === 'delete') {
    if ($exists) {
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    }
}

// balik ke halaman cart
header("Location: cart.php");
exit;
?>
