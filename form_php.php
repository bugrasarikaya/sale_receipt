<?php
    if(empty($_POST)){
        header("Location: form.html");
        exit;
    }
    try{
        $dsn="mysql:host=localhost;dbname=receipts;charset=utf8";
        $conn=new PDO($dsn, "root","");
    }catch(PDOException $e){
        print $e->getMessage();
    }
    $name=$_POST["name"];
    $surname=$_POST["surname"];
    $tel=$_POST["tel"];
    $email=$_POST["email"];
    $address=$_POST["address"];
    try{
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql="INSERT INTO users (name,surname,tel,email,address) VALUES ('$name','$surname','$tel','$email','$address');";
        $conn->exec($sql);
        header("Location: form.html");
    }catch(PDOException $e){
        echo "<br>",$e->getMessage();
    }
?>
