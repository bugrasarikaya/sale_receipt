<?php
    if(empty($_POST)){
        header("Location: form.html");
        exit;
    }
    $product_id=$_POST["product"];
    session_start();
    if(!isset($_SESSION['cart'][$product_id])) $_SESSION['cart'][$product_id]=0;
    $_SESSION['cart'][$product_id]++;
    header("Location: cart_page.php");
?>
