<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        if(!isset($_SESSION['customer']) || empty($_SESSION['customer'])){
            if(!isset($_SESSION['address']) || empty($_SESSION['address'])){
                if(!isset($_SESSION['payment']) || empty($_SESSION['payment'])){
                    header("Location: cart.php");
                    exit();
                }
            }
        }
    }
    if(isset($_SESSION['purchased']) || !empty($_SESSION['purchased']))header("Location: cart.php");
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
            #info_container{
            	margin-bottom: 30px;
                padding: 10px;
                width: 1110px;
				background: #414A4C;
                border: 5px solid #404040;
				border-radius: 3px;
				float: left;
            }
            #info_container h3{
                margin-top: 10px;
                margin-bottom: 0px;
                margin-left: 40px;
                text-align: left;
            }            
            #info_container .subtitle{
                text_align: left;
            }
            #info_container .value{
                width: 81.5%;
                padding-right: 5px;
                height: 20px;
                background-color: rgba(128,128,128, 0.4);
                border: none;
                font-size: 90%;
                border-radius: 3px;
                float: right;
                text-align: right;
                color: white;
                outline: none;
            }
            table{
                width: 1110px;
                border-collapse: collapse;
			}
			table thead{			
                text-align: left;
			}
			table #title_quantity{
                text-align: center;
			}
			table #title_price{
                text-align: center;
			}
			table tr{
                height: 39px;
				border-bottom: 1px solid white;
            }
			table tr:last-child{
				border-bottom: none
			}
			table #title_quantity, #title_price, .quantity, .price{
                text-align: center;
			}
            #info_container .title{
                margin-top: 25px;
            }    
            #sales_summary_container #line{
                margin-top: 25px;
                margin-bottom: 3px;
                width: 100%;
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
	</head>
	<body>
		<div class="logo_container">
			<a href="product_catalog.php"><img src="ELYSIUM Bilgisayar Sistemleri (Transparent).png" id="logo_image" alt="logo"></a>
		</div>
		<div id='main_container'>
		<div id='info_container'>
		<h3>Sepet</h3>
		<hr>
		<table>
        	<thead>
		    	<tr>
	            	<th>Ürün</th>
		        	<th id="title_quantity">Ürün Adedi</th>
		        	<th id="title_price">Fiyat</th>
		        	<th></th>
		        </tr>
		    </thead>
	     	<tbody>
				<?php 
	               foreach($_SESSION['cart'] as $product_id => $quantity){
	                   echo "<tr>"
	                           ."<td>".product_name($product_id)."</td>"
	                           ."<td class='quantity'>".$quantity."</td>"
                               ."<td class='price'>".product_price($product_id)*$quantity." TL</td>"
	                       ."</tr>";
	                }
		          ?>
			</tbody>
		</table>
				<h3 class="title">Müşteri Bilgileri</h3>
				<hr>
				<label class="subtitle">İsim:</label><label class="value"><?php echo $_SESSION['customer']['name']; ?></label><br />
				<hr>
				<label class="subtitle">Soyad:</label><label class="value"><?php echo $_SESSION['customer']['surname']; ?></label><br />
				<hr>
				<label class="subtitle">T.C. Kimlik No:</label><label class="value"><?php echo $_SESSION['customer']['personal_id']; ?></label><br />
				<hr>
				<label class="subtitle">Tel:</label><label class="value"><?php echo $_SESSION['customer']['tel']; ?></label><br />
				<hr>
				<label class="subtitle">E-Posta:</label><label class="value"><?php echo $_SESSION['customer']['email']; ?></label><br />
				<h3 class="title">Fatura Adresi Bilgileri</h3>
				<hr>
				<label class="subtitle">Ülke:</label><label class="value"><?php echo $_SESSION['address']['country']; ?></label><br />
				<hr>
				<label class="subtitle">İl:</label><label class="value"><?php echo $_SESSION['address']['state']; ?></label><br />
				<hr>
				<label class="subtitle">İlçe:</label><label class="value"><?php echo $_SESSION['address']['city']; ?></label><br />
				<hr>
				<label class="subtitle">Mahalle:</label><label class="value"><?php echo $_SESSION['address']['street']; ?></label><br />
				<hr>
				<label class="subtitle">Posta Kodu:</label><label class="value"><?php echo $_SESSION['address']['postal_code']; ?></label><br />
				<hr>
				<label class="subtitle">Adres:</label><label class="value"><?php echo $_SESSION['address']['address']; ?></label><br />
				<h3 class="title">Ödeme Bilgileri</h3>
				<hr>
				<label class="subtitle">Kart Sahibinin İsmi:</label><label class="value"><?php echo $_SESSION['payment']['name']; ?></label><br />
				<hr>
				<label class="subtitle">Kart Numarası:</label><label class="value"><?php echo $_SESSION['payment']['card_number']; ?></label><br />
				<hr>
				<label class="subtitle">Son Kullanma Ayı:</label><label class="value"><?php echo $_SESSION['payment']['expiry_month']; ?></label><br />
				<hr>
				<label class="subtitle">Son Kullanma Yılı:</label><label class="value"><?php echo $_SESSION['payment']['expiry_year']; ?></label><br />
				<hr>
				<label class="subtitle">CVV:</label><label class="value"><?php echo $_SESSION['payment']['cvv']; ?></label><br />
		</div>
		<div id='sales_summary_container'>
			<h3>Satış Özeti</h3>
			<hr>
			<label class='subtitle'>Ürün Adedi:</label><label class='value'><?php $product_count=0; foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity; echo $product_count;?></label><br/>
			<label class='subtitle'>Ödenecek Tutar:</label><label class='value'><?php $cost=0; foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity; echo $cost; ?> TL</label><br/>
			<hr id='line'>
			<button type="submit" id='continue_button' onclick="window.location.href='checkout_server.php'">Tamamla</button>
		</div>
		</div>
	</body>
</html>