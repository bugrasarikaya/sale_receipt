<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        if(!isset($_SESSION['customer']) || empty($_SESSION['customer'])){
            header("Location: cart.php");
            exit();
        }
    }
    $_SESSION['address']['country']=$_POST["country"];
    $_SESSION['address']['state']=$_POST["state"];
    $_SESSION['address']['city']=$_POST["city"];
    $_SESSION['address']['street']=$_POST["street"];
    $_SESSION['address']['postal_code']=$_POST["postal_code"];
    $_SESSION['address']['address']=$_POST["address"];
    header("Location: payment_info.php");
?>