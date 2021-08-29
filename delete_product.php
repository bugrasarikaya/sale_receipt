<?php
    if(empty($_POST)){
        header("Location: form.html");
        exit;
    }
    $product_id=$_POST["product_id"];
    session_start();
    unset($_SESSION['cart'][$product_id]);
    if(empty($_SESSION['cart'])) unset($_SESSION['cart']);
    header("Location: cart_page.php");
?>