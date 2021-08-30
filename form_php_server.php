<?php
    if(!isset($_POST) || empty($_POST)){
        header("Location: form.html");
        exit;
    }
    try{
        $dsn="mysql:host=localhost;dbname=receipts_db;charset=utf8";
        $conn=new PDO($dsn, "root","");
    }catch(PDOException $e){
        print $e->getMessage();
    }
    $name=$_POST["name"];
    $surname=$_POST["surname"];
    $tel=$_POST["tel"];
    $email=$_POST["email"];
    $address=$_POST["address"];
    $product_1=$_POST["product_1"];
    $product_2=$_POST["product_2"];
    $product_3=$_POST["product_3"];
    $product_4=$_POST["product_4"];
    $product_5=$_POST["product_5"];
    $product_6=$_POST["product_6"];
    $product_7=$_POST["product_7"];
    $product_8=$_POST["product_8"];
    $product_9=$_POST["product_9"];
    $product_10=$_POST["product_10"];
    $product_11=$_POST["product_11"];
    $product_12=$_POST["product_12"];
    try{
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql_1="INSERT INTO customers (name,surname,tel,email,address) VALUES ('$name','$surname','$tel','$email','$address')";
        $conn->exec($sql_1);
        $sql_2="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'receipts_db' AND TABLE_NAME = 'customers';";
        $stmt_2=$conn->query($sql_2);
        $sth_2=$stmt_2->fetch(\PDO::FETCH_ASSOC);
        $sql_3="INSERT INTO receipts (customer_id, product_1, product_2, product_3, product_4, product_5, product_6, product_7, product_8, product_9, product_10, product_11, product_12) VALUES ('".$sth_2['AUTO_INCREMENT']."', '$product_1', '$product_2', '$product_3', '$product_4', '$product_5', '$product_6', '$product_7', '$product_8', '$product_9', '$product_10', '$product_11', '$product_12')";
        $conn->exec($sql_3);
        header("Location: form.html");
    }catch(PDOException $e){
        echo "<br>",$e->getMessage();
    }
?>