<?php
    if(!isset($_POST) || empty($_POST)){
        header("Location: product_catalog.php");
        exit();
    }
    $product_id=$_POST["product"];
    session_start();
    if(!isset($_SESSION['cart'][$product_id])) $_SESSION['cart'][$product_id]=0;
    $_SESSION['cart'][$product_id]++;
    header("Location: cart.php");
?>