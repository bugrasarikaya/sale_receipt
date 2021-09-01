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
		<title>Ödeme Bilgileri</title>
	</head>
	<body>
		<form action="payment_info_server.php" method="post" id="address_info_form">
			<fieldset>
				<legend>Ödeme Bilgileri</legend>
				<label>Kart Sahibinin İsmi:<input type="text" name="name" maxlength="80"></label><br />
				<hr>
				<label>Kart Numarası:<input type="text" name="card_number" maxlength="16"></label><br />
				<hr>
				<label>Son Kullanma Ayı:<input type="number" name="expiry_month" maxlength="2"></label><br />
				<hr>
				<label>Son Kullanma Yılı:<input type="number" name="expiry_year" maxlength="4"></label><br />
				<hr>
				<label>CVV:<input type="text" name="cvv" maxlength="3"></label><br />
			</fieldset>
		</form>
		<fieldset>
			<legend>Satış Özeti</legend>
			<label>Ürün Adedi:</label><label><?php $product_count=0; foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity; echo $product_count;?></label><br/>
			<hr>
			<label>Ödenecek Tutar:</label><label><?php $cost=0; foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity; echo $cost; ?></label><br/>
			<button type="submit" form="address_info_form">Devam Et</button>
		</fieldset>
	</body>
</html>