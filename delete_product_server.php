<?php
    if(!isset($_POST) || empty($_POST)){
        header("Location: cart_page.html");
        exit();
    }
    $product_id=$_POST["product_id"];
    session_start();
    unset($_SESSION['cart'][$product_id]);
    if(empty($_SESSION['cart'])) unset($_SESSION['cart']);
    header("Location: cart_page.php");
?>
