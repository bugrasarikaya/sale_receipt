<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        header("Location: cart_page.php");
        exit();
    }
    $_SESSION['customer']['name']=$_POST["name"];
    $_SESSION['customer']['surname']=$_POST["surname"];
    $_SESSION['customer']['personal_id']=$_POST["personal_id"];
    $_SESSION['customer']['tel']=$_POST["tel"];
    $_SESSION['customer']['email']=$_POST["email"];
    header("Location: address_info_page.php");
?>