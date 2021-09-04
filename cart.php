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
            body{
                background: radial-gradient(#BEBEBE, #2A2A2A);
                background-size: 100% 1000px;
                font-family: Arial, sans-serif;
                font-weight: normal;
                font-size: 130%;
                color: white;
            }
            .logo_container{
                margin-top: 40px;
				margin-right: auto;
				margin-bottom: auto;
				margin-left: auto;
				transform: translateX(-21px);
				width: 300px;
				background-color: white;
            }
            #logo_image{
                margin-top: 40px;
				margin-right: auto;
				margin-bottom: auto;
				margin-left: auto;
                width: 300px;
                padding: 10px;
                display: flex;
                background-color: white;
                border-style: solid;
                border-color: black;
            }
            #main_container{
                margin-top: 30px;
				margin-right: auto;
				margin-bottom: auto;
				margin-left: auto;
				width: 1500px;
			}
            #table_container{
                padding: 10px;
                width: 1110px;
				background: #414A4C;
                border: 5px solid #404040;
				border-radius: 3px;
				float: left;
            }
            #table_container h3{
                margin-top: 10px;
                margin-bottom: 0px;
                margin-left: 40px;
                text-align: left;
            }
            table{
                width: 1110px;
                border-collapse: collapse
			}
			thead{			
                text-align: left;
			}
			#title_quantity{
                text-align: center;
			}
			#title_price{
                text-align: center;
			}
			tr{
				border-bottom: 1px solid white;
            }
			tr:last-child{
				border-bottom: none
			}
            .input_quantity{
                margin-left: 50%;
                transform: translateX(-50%);
                width: 40px;
                background-color: rgba(128,128,128, 0.4);
                border: none;
                font-size: 90%;
                border-radius: 3px;
                outline: none;
                text-align: left;
                color: white;
            }
            .price{
                text-align: center;
            }
            .delete_button{
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
            .delete_button:hover{
                background-color: #E02E2E;
                cursor: pointer;
			}
            .delete_button:active{
                background-color: #C61414;
            }
            #sales_summary_container{
                margin-left: 100%;
                transform: translateX(-100%);
                padding: 10px;
                width: 310px;
                height: 200px;
				background: #414A4C;
                border: 5px solid #404040;
				border-radius: 3px;
            }
            #sales_summary_container h3{
                margin-top: 10px;
                margin-bottom: 0px;
                text-align: center;
            }
            #sales_summary_container .subtitle{
                margin-top: 5px;
                margin-bottom: 5px;
                width: 160px;
                float: left;     
            }
            #sales_summary_container .value{
                margin-top: 5px;
                margin-bottom: 5px;
                float: right;      
            }
            #sales_summary_container #line{
                margin-top: 25px;
                margin-bottom: 3px;
                width: 100%;
            }
            #sales_summary_container #continue_button{
				margin-top: 15px;
  				margin-left: 50%;
    			transform: translateX(-50%);
    			width: 110px;
    			height: 32px;
    			border: none;
    			border-radius: 5px;
    			background-color: #DD1717;
    			font-size: 19px;
    			text-align: center;
    			color: white;
            }
            #sales_summary_container #continue_button:hover{
                background-color: #E02E2E;
                cursor: pointer;
            }
		</style>
		<script>
			function submit_form(form){
				var x=form.product_quantity.value;
				if(x!="") form.submit();
			}
		</script>
	</head>
	<body>
		<div class="logo_container">
			<a href="product_catalog.php"><img src="ELYSIUM Bilgisayar Sistemleri (Transparent).png" id="logo_image" alt="logo"></a>
		</div>
		<?php 
		  echo "<div id='main_container'>";
		  if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
		      echo "<div id='table_container'>" 
               ."<h3>Sepet</h3>"
                ."<hr>"
		          ."<table>"
                    ."<thead>"
		              ."<tr>"
	                      ."<th>Ürün</th>"
		                  ."<th id='title_quantity' >Ürün Adedi</th>"
		                  ."<th id='title_price'>Fiyat</th>"
		                  ."<th></th>"
		              ."</tr>"
		            ."</thead>"
	                ."<tbody>";
	                foreach($_SESSION['cart'] as $product_id => $quantity){
	                   echo "<tr>"
	                           ."<td>".product_name($product_id)."</td>"
	                           ."<td><form action='change_quantity_server.php' method='post'><input type='hidden' name='product_id' value='".$product_id."'><input type='number' class='input_quantity' name='product_quantity' min='1' value='".$quantity."' onchange='submit_form(this.form)' required></form></td>"
                               ."<td class='price'>".product_price($product_id)*$quantity."</td>"
                               ."<td><form action='delete_product_server.php' method='post'><input type='hidden' name='product_id' value='".$product_id."'><input type='submit' name='delete_button' class='delete_button' value=''></form></td>"
	                       ."</tr>";
	                }
	          echo   "</tbody>"
		            ."</table>"
                    ."</div>";
		      $product_count=0;
		      foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity;
		      $cost=0;
		      foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity;
		      echo "<div id='sales_summary_container'>"
                            ."<h3>Satış Özeti</h3>"
                            ."<hr>"
                            ."<label class='subtitle'>Ürün Adedi:</label><label class='value'>".$product_count."</label><br />"
                            ."<label class='subtitle'>Ödenecek Tutar:</label><label class='value'>".$cost." TL</label><br/>"
                            ."<hr id='line'>"
	                       ."<button id='continue_button' onclick=\"window.location.href='customer_info.php'\">Satın Al</button>"
                    ."</div>"
                    ."</div>";
        }else{
            echo "<script>alert('Sepetinizde hiç ürün bulunmamaktadır.');  window.location.href = 'product_catalog.php'; </script>";
		}
		?>
	</body>
</html>