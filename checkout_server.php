<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        if(!isset($_SESSION['customer']) || empty($_SESSION['customer'])){
            if(!isset($_SESSION['address']) || empty($_SESSION['address'])){
                if(!isset($_SESSION['payment']) || empty($_SESSION['payment'])){
                    header("Location: cart.php");
                    exit();
                }
            }
        }
    }
    function product_price($product_id){
        try{
            $dsn="mysql:host=localhost;dbname=receipts_db;charset=utf8";
            $conn=new PDO($dsn, "root","");
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $sql="SELECT price FROM products WHERE product_id='$product_id'";
            $stmt=$conn->query($sql);
            $sth=$stmt->fetch(\PDO::FETCH_ASSOC);
            $conn=null;
            return $sth['price'];
        }catch(PDOException $e){
            echo "<br>",$e->getMessage();
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
        $cost=0;
        foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity;
        $sql_6="INSERT INTO receipts (receipt_id, customer_id, address_id, payment_id, purchase_id, cost, date) VALUES ('".$sth_1['AUTO_INCREMENT']."', '".$sth_2['AUTO_INCREMENT']."', '".$sth_3['AUTO_INCREMENT']."', '".$sth_4['AUTO_INCREMENT']."', '".$sth_5['AUTO_INCREMENT']."', '$cost', '$date')";
        $conn->exec($sql_6);
        $sql_7="INSERT INTO customers (customer_id, name, surname, personal_id, tel, email) VALUES ('".$sth_2['AUTO_INCREMENT']."', '".$_SESSION['customer']['name']."', '".$_SESSION['customer']['surname']."', '".$_SESSION['customer']['personal_id']."', '".$_SESSION['customer']['tel']."', '".$_SESSION['customer']['email']."')";
        $conn->exec($sql_7);
        $sql_8="INSERT INTO addresses (address_id, country, state, city, street, postal_code, address) VALUES ('".$sth_3['AUTO_INCREMENT']."', '".$_SESSION['address']['country']."', '".$_SESSION['address']['state']."', '".$_SESSION['address']['city']."', '".$_SESSION['address']['street']."', '".$_SESSION['address']['postal_code']."', '".$_SESSION['address']['address']."')";
        $conn->exec($sql_8);
        $sql_9="INSERT INTO payments (payment_id, name, card_number, expiry_month, expiry_year, cvv) VALUES ('".$sth_4['AUTO_INCREMENT']."', '".$_SESSION['payment']['name']."', '".$_SESSION['payment']['card_number']."', '".$_SESSION['payment']['expiry_month']."', '".$_SESSION['payment']['expiry_year']."', '".$_SESSION['payment']['cvv']."')";
        $conn->exec($sql_9);
        foreach($_SESSION['cart'] as $product_id => $quantity){
            $sql_10="INSERT INTO purchases (purchase_id, product_id, quantity) VALUES ('".$sth_5['AUTO_INCREMENT']."', '$product_id', '$quantity')";
            $conn->exec($sql_10);
        }
        $conn=null;
        $receipt_id=$sth_1['AUTO_INCREMENT'];
        session_destroy();
        session_start();
        $_SESSION['receipt_id']=$receipt_id;
        $_SESSION['purchased']=true;
        header("Location: post_checkout.php");
    }catch(PDOException $e){
        echo "<br>",$e->getMessage();
    }
?>