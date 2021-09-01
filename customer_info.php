<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        header("Location: cart_page.html");
        exit();
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
		<form action="customer_info_server.php" method="post" id="customer_info_form">
			<fieldset>
				<legend>Müşteri Bilgileri</legend>
				<label>İsim:<input type="text" name="name" maxlength="40"></label><br />
				<hr>
				<label>Soyad:<input type="text" name="surname" maxlength="40"></label><br />
				<hr>
				<label>T.C. Kimlik No:<input type="text" name="personal_id" maxlength="11"></label><br />
				<hr>
				<label>Tel:<input type="tel" name="tel" maxlength="11"></label><br />
				<hr>
				<label>E-Posta:<input type="email" name="email" maxlength="60"></label><br />
			</fieldset>
		</form>
		<fieldset>
			<legend>Satış Özeti</legend>
			<label>Ürün Adedi:</label><label><?php $product_count=0; foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity; echo $product_count;?></label><br/>
			<hr>
			<label>Ödenecek Tutar:</label><label><?php $cost=0; foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity; echo $cost; ?></label><br/>
			<button type="submit" form="customer_info_form">Devam Et</button>
		</fieldset>
	</body>
</html>