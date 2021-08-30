<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        header("Location: customer_info.php");
    }
    $product_id=$_POST["product_id"];
    $product_quantity=$_POST["product_quantity"];
    session_start();
    if(isset($_SESSION['cart'][$product_id]) && !empty($_SESSION['cart'][$product_id])) $_SESSION['cart'][$product_id]=$product_quantity;
    header("Location: cart_page.php");
?>