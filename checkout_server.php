<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        if(!isset($_SESSION['customer']) || empty($_SESSION['customer'])){
            if(!isset($_SESSION['address']) || empty($_SESSION['address'])){
                if(!isset($_SESSION['payment']) || empty($_SESSION['payment'])){
                    header("Location: cart_page.php");
                    exit();
                }
            }
        }
    }
    try{
        $dsn="mysql:host=localhost;dbname=receipts_db;charset=utf8";
        $conn=new PDO($dsn, "root","");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql_1="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'receipts_db' AND TABLE_NAME = 'receipts';";
        $stmt_1=$conn->query($sql_1);
        $sth_1=$stmt_1->fetch(\PDO::FETCH_ASSOC);
        $sql_2="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'receipts_db' AND TABLE_NAME = 'customers';";
        $stmt_2=$conn->query($sql_2);
        $sth_2=$stmt_2->fetch(\PDO::FETCH_ASSOC);
        $sql_3="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'receipts_db' AND TABLE_NAME = 'addresses';";
        $stmt_3=$conn->query($sql_3);
        $sth_3=$stmt_3->fetch(\PDO::FETCH_ASSOC);
        $sql_4="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'receipts_db' AND TABLE_NAME = 'payments';";
        $stmt_4=$conn->query($sql_4);
        $sth_4=$stmt_4->fetch(\PDO::FETCH_ASSOC);
        $sql_5="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'receipts_db' AND TABLE_NAME = 'purchases';";
        $stmt_5=$conn->query($sql_5);
        $sth_5=$stmt_5->fetch(\PDO::FETCH_ASSOC);
        $date=date('Y-m-d H:i:s');
        $sql_6="INSERT INTO receipts (receipt_id, customer_id, address_id, payment_id, purchase_id, date) VALUES ('".$sth_1['AUTO_INCREMENT']."', '".$sth_2['AUTO_INCREMENT']."', '".$sth_3['AUTO_INCREMENT']."', '".$sth_4['AUTO_INCREMENT']."', '".$sth_5['AUTO_INCREMENT']."', '$date')";
        $conn->exec($sql_6);
        $sql_7="INSERT INTO customers (customer_id, name, surname, tel, email) VALUES ('".$sth_2['AUTO_INCREMENT']."', '".$_SESSION['cart']['name']."', '".$_SESSION['cart']['surname']."', '".$_SESSION['cart']['tel']."', '".$_SESSION['cart']['email']."')";
        $conn->exec($sql_7);
        $sql_8="INSERT INTO addresses (address_id, country, state, city, street, postal_code, address) VALUES ('".$sth_3['AUTO_INCREMENT']."', '".$_SESSION['cart']['country']."', '".$_SESSION['cart']['state']."', '".$_SESSION['cart']['city']."', '".$_SESSION['cart']['street']."', '".$_SESSION['cart']['postal_code']."', '".$_SESSION['cart']['address']."')";
        $conn->exec($sql_8);
        $sql_9="INSERT INTO payments (payment_id, name, card_number, expiry_month, expiry_year, cvv) VALUES ('".$sth_4['AUTO_INCREMENT']."', '".$_SESSION['cart']['name']."', '".$_SESSION['cart']['card_number']."', '".$_SESSION['cart']['expiry_month']."', '".$_SESSION['cart']['expiry_year']."', '".$_SESSION['cart']['cvv']."')";
        $conn->exec($sql_9);
        $sql_10="INSERT INTO purchases (purchase_id, product_id, quantity) VALUES ('".$sth_5['AUTO_INCREMENT']."', '".$_SESSION['cart']['product_id']."', '".$_SESSION['cart']['quantity']."')";
        $conn->exec($sql_10);
        $conn=null;
        unset($_SESSION);
        $_SESSION['receipt_id']=$sth_1['AUTO_INCREMENT'];
        header("Location: after_checkout.php");
    }catch(PDOException $e){
        echo "<br>",$e->getMessage();
    }
?>