<?php
    session_start();
    function product_name($product_id){
        try{
            $dsn="mysql:host=localhost;dbname=receipts_db;charset=utf8";
            $conn=new PDO($dsn, "root","");
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $sql="SELECT name FROM products WHERE product_id='$product_id'";
            $stmt=$conn->query($sql);
            $sth=$stmt->fetch(\PDO::FETCH_ASSOC);
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
		<title>Sepet</title>
	</head>
	<body>
		<?php 
		  if(isset($_SESSION['cart'])){
		      echo "<table>"
                    ."<thead>"
		              ."<tr>"
		                  ."<th><input type='checkbox' id='all_check' name='all_check' value='1'></th>"
	                      ."<th>Ürün</th>"
		                  ."<th>Ürün Adedi</th>"
		                  ."<th>Fiyat</th>"
		                  ."<th></th>"
		              ."</tr>"
		            ."</thead>"
	                ."<tbody>";
	                foreach($_SESSION['cart'] as $product_id => $quantity){
	                   if($quantity!=0){
	                       echo "<tr>"
	                               ."<td><input type='checkbox' id='checkbox_product_".$product_id."' name='checkbox_product_".$product_id."' value='1'></td>"
	                               ."<td>".product_name($product_id)."</td>"
	                               ."<td><input type='number' id='quantity_product_".$product_id."' name='quantity_product_".$product_id."' min='1' value='".$quantity."'></td>"
	                               ."<td>".product_price($product_id)."</td>"
	                               ."<td></td>"
	                           ."</tr>";
	                   }
	                }
	          echo   "</tbody>"
		            ."</table>";
		  }else{
		      echo "<p>Sepetinizde hiç ürün bulunmamaktadır.</p>";
		  }
		?>
	</body>
</html>
