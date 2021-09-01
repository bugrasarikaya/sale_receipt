<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        if(!isset($_SESSION['customer']) || empty($_SESSION['customer'])){
            header("Location: cart_page.php");
            exit();
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
		<title>Fatura Adresi Bilgileri</title>
	</head>
	<body>
		<form action="address_info_server.php" method="post" id="address_info_form">
			<fieldset>
				<legend>Fatura Adresi Bilgileri</legend>
				<label>Ülke<input type="text" name="country" maxlength="40"></label><br />
				<hr>
				<label>İl:<input type="text" name="state" maxlength="40"></label><br />
				<hr>
				<label>İlçe:<input type="text" name="city" maxlength="40"></label><br />
				<hr>
				<label>Mahalle:<input type="text" name="street" maxlength="40"></label><br />
				<hr>
				<label>Posta Kodu:<input type="text" name="postal_code" maxlength="6"></label><br />
				<hr>
				<label>Adres:<input type="email" name="address" maxlength="100"></label><br />
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