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
    function product_name($product_id){
        try{
            $dsn="mysql:host=localhost;dbname=receipts_db;charset=utf8";
            $conn=new PDO($dsn, "root","");
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $sql="SELECT name FROM products WHERE product_id='$product_id'";
            $stmt=$conn->query($sql);
            $sth=$stmt->fetch(\PDO::FETCH_ASSOC);
            $conn=null;
            return $sth['name'];
        }catch(PDOException $e){
            echo "<br>",$e->getMessage();
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
		<title>Satış Özeti</title>
		<style>

		</style>
	</head>
	<body>
		<table>
        	<thead>
		    	<tr>
	            	<th>Ürün</th>
		        	<th>Ürün Adedi</th>
		        	<th>Fiyat</th>
		        	<th></th>
		        </tr>
		    </thead>
	     	<tbody>
				<?php 
	               foreach($_SESSION['cart'] as $product_id => $quantity){
	                   echo "<tr>"
	                           ."<td>".product_name($product_id)."</td>"
	                           ."<td>".$quantity."</td>"
                               ."<td>".product_price($product_id)*$quantity."</td>"
	                       ."</tr>";
	                }
		          ?>
			</tbody>
		</table>
		<fieldset>
			<legend>Müşteri Bilgileri</legend>
			<label>İsim:</label><label><?php echo $_SESSION['customer']['name']; ?></label><br />
			<hr>
			<label>Soyad:</label><label><?php echo $_SESSION['customer']['name']; ?></label><br />
			<hr>
			<label>T.C. Kimlik No:</label><?php echo $_SESSION['customer']['name']; ?><label></label><br />
			<hr>
			<label>Tel:</label><label><?php echo $_SESSION['customer']['name']; ?></label><br />
			<hr>
			<label>E-Posta:</label><label><?php echo $_SESSION['customer']['name']; ?></label><br />
		</fieldset>
		<fieldset>
			<legend>Fatura Adresi Bilgileri</legend>
			<label>Ülke:</label><label><?php echo $_SESSION['address']['country']; ?></label><br />
			<hr>
			<label>İl:</label><label><?php echo $_SESSION['address']['state']; ?></label><br />
			<hr>
			<label>İlçe:</label><label><?php echo $_SESSION['address']['city']; ?></label><br />
			<hr>
			<label>Mahalle:</label><label><?php echo $_SESSION['address']['street']; ?></label><br />
			<hr>
			<label>Posta Kodu:</label><label><?php echo $_SESSION['address']['postal_code']; ?></label><br />
			<hr>
			<label>Adres:</label><label><?php echo $_SESSION['address']['address']; ?></label><br />
		</fieldset>
		<fieldset>
			<legend>Ödeme Bilgileri</legend>
			<label>Kart Sahibinin İsmi:</label><label><?php echo $_SESSION['payment']['name']; ?></label><br />
			<hr>
			<label>Kart Numarası:</label><label><?php echo $_SESSION['payment']['card_number']; ?></label><br />
			<hr>
			<label>Son Kullanma Ayı:</label><label><?php echo $_SESSION['payment']['expiry_month']; ?></label><br />
			<hr>
			<label>Son Kullanma Yılı:</label><label><?php echo $_SESSION['payment']['expiry_year']; ?></label><br />
			<hr>
			<label>CVV:</label><label><?php echo $_SESSION['payment']['cvv']; ?></label><br />
		</fieldset>
		<fieldset>
			<legend>Satış Özeti</legend>
			<label>Ürün Adedi:</label><label><?php $product_count=0; foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity; echo $product_count;?></label><br/>
			<hr>
			<label>Ödenecek Tutar:</label><label><?php $cost=0; foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity; echo $cost; ?></label><br/>
			<button onclick="window.location.href='checkout_server.php'">Satışı Onayla</button>
		</fieldset>
	</body>
</html>