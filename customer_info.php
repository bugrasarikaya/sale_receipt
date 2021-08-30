<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        header("Location: product_catalog.html");
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
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Müşteri Bilgileri</title>
	</head>
	<body>
		<form action="form_php.php" method="post">
			<fieldset>
				<legend>Müşteri Bilgileri</legend>
				<label>İsim:<input type="text" name="name" maxlength="50"></label><br />
				<hr>
				<label>Soyad:<input type="text" name="surname" maxlength="50"></label><br />
				<hr>
				<label>T.C. Kimlik No:<input type="text" name="personal_id" maxlength="11"></label><br />
				<hr>
				<label>Tel:<input type="tel" name="tel" size="30" maxlength="15"></label><br />
				<hr>
				<label>E-Posta:<input type="email" name="email" size="30" maxlength="100"></label><br />
				<input type="submit" name="send" id="send" value="Gönder"/>
			</fieldset>
		</form>
		<fieldset>
			<legend>Satış Özeti</legend>
			<label>Ürün Adedi:</label><label><?php $product_count=0; foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity; echo $product_count;?></label><br/>
			<hr>
			<label>Ödenecek Tutar:</label><label><?php $cost=0; foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity; echo $cost; ?></label><br/>
			<button onclick="window.location.href='customer_info_server.php'">Satın Al</button>
		</fieldset>
	</body>
</html>