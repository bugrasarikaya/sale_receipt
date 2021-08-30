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
		<title>Sepet</title>
		<style>
		  #delete_button{
		      margin-top: 10px;
  	          margin-left: 50%;
    		  transform: translateX(-50%);
    		  width: 30px;
    		  height: 30px;
              border: none;
    		  border-radius: 11px;
    		  background-image: url(delete.png);
    		  background-size: 18px auto;
    		  background-repeat: no-repeat;
    		  background-position: center;
    		  background-color: #DD1717;
		  }
		  #delete_button:hover{
		      background-color: #E02E2E;
			}
		  #delete_button:active{
		      background-color: #C61414;
			}			
		</style>
	</head>
	<body>
		<?php 
		  if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
		      echo "<table>"
                    ."<thead>"
		              ."<tr>"
	                      ."<th>Ürün</th>"
		                  ."<th>Ürün Adedi</th>"
		                  ."<th>Fiyat</th>"
		                  ."<th></th>"
		              ."</tr>"
		            ."</thead>"
	                ."<tbody>";
	                foreach($_SESSION['cart'] as $product_id => $quantity){
	                   echo "<tr>"
	                           ."<td>".product_name($product_id)."</td>"
	                           ."<td><form action='change_quantity_server.php' method='post'><input type='hidden' name='product_id' value='".$product_id."'><input type='number' class='product_quantity' name='product_quantity' min='1' value='".$quantity."' onchange='this.form.submit()'></form></td>"
                               ."<td>".product_price($product_id)*$quantity."</td>"
                               ."<td><form action='delete_product_server.php' method='post'><input type='hidden' name='product_id' value='".$product_id."'><input type='submit' name='delete_button' id='delete_button' value=''></form></td>"
	                       ."</tr>";
	                }
	          echo   "</tbody>"
		            ."</table>";
		  }else{
		      echo   "<p>Sepetinizde hiç ürün bulunmamaktadır.</p>";
		  }
		?>
		<fieldset>
			<legend>Satış Özeti</legend>
			<label>Ürün Adedi:</label><label><?php $product_count=0; foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity; echo $product_count;?></label><br/>
			<hr>
			<label>Ödenecek Tutar:</label><label><?php $cost=0; foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity; echo $cost; ?></label><br/>
			<button onclick="window.location.href='customer_info.php'">Satın Al</button>
		</fieldset>
	</body>
</html>