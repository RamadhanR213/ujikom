<?php
session_start();

if (isset($_GET['p'])) {
    $id = $_GET['p'];


    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]--;


        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
    
}

header("Location: cart.php");
exit();
