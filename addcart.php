<?php

session_start();
include 'koneksi.php';

$id = $_GET['p'];

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += 1;
} else {
    $_SESSION['cart'][$id] = 1;
}

header("location:cart.php?p=$id");
