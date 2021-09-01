<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        if(!isset($_SESSION['customer']) || empty($_SESSION['customer'])){
            if(!isset($_SESSION['address']) || empty($_SESSION['address'])){
                header("Location: cart_page.php");
                exit();
            }
        }
    }
    $_SESSION['payment']['name']=$_POST["name"];
    $_SESSION['payment']['card_number']=$_POST["card_number"];
    $_SESSION['payment']['expiry_month']=$_POST["expiry_month"];
    $_SESSION['payment']['expiry_year']=$_POST["expiry_year"];
    $_SESSION['payment']['cvv']=$_POST["cvv"];
    header("Location: checkout.php");
?>