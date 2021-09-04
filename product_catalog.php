<?php 
    try{
        $dsn="mysql:host=localhost;dbname=receipts_db;charset=utf8";
        $conn=new PDO($dsn, "root","");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql="SELECT * FROM products";
        $stmt=$conn->query($sql);
        if($stmt->rowCount()==0) header("Location: homepage.html");
        $conn=null;
    }catch(PDOException $e){
        echo "<br>",$e->getMessage();
    }
    session_start();
    if(isset($_SESSION['purchased']) || !empty($_SESSION['purchased'])) unset($_SESSION['purchased']);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ürün Kataloğu</title>
		<style>
            body{
                background: radial-gradient(#BEBEBE, #2A2A2A);
                background-size: 100% 100%;
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
				transform: translateX(-13px);
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
            #cart{
  				margin-left: 100%;
                transform: translate(-95%, -116%);
				width: 100px;
				height: 30px;
    			border: none;
				border-top-left-radius: 5px;
                border-top-right-radius: 5px;
				background-color: #008000;
				color: white;
			    text-align: center;
			}
			#cart:hover{
                background: #198c19;
                cursor: pointer;
            }
			.catalog_container{
				margin-top: 50px;
				margin-right: auto;
				margin-bottom: 50px;
				margin-left: auto;
				padding-bottom: 20px;
				width: 1400px;
				background: #414A4C;
                border: 5px solid #404040;
				border-radius: 3px;
				border-top-right-radius: 0px;
			}
			.catalog_container .product_row{
				margin: 5px;
				display: flex;
				justify-content: center;
			}
			.catalog_container .product_row .product{
				margin: 10px;
				padding: 10px;
				border-radius: 3px;
				background: #232B2B;
			}
			.catalog_container .product_row .product:hover{
				background: #353839;
			}
			.catalog_container .product_row #product_image{
				border-radius: 3px;
			}		
			.catalog_container .product_row .name{
				margin: 10px;
				margin-right: auto;
				margin-bottom: auto;
				margin-left: auto;
				padding-top: 2px;
				width: 80%;
				display: block;
				border-radius: 4px;
				border-style: solid;
                border-color: #00007f;
				background: black;
				text-align: center;
			}
			.catalog_container .product_row .price{
				margin: 10px;
				margin-right: auto;
				margin-bottom: auto;
				margin-left: auto;
				padding-top: 2px;
				width: 40%;
				display: block;
				border-radius: 4px;
				border-style: solid;
                border-color: #00007f;
				background: black;
				text-align: center;
			}	
			.catalog_container .product_row .product .add_product{
				margin-top: 10px;
  				margin-left: 50%;
    			transform: translateX(-50%);
    			width: 113px;
    			height: 32px;
    			border: none;
    			border-radius: 5px;
    			background-image: url(cart.png);
    			background-size: 30px auto;
    			background-repeat: no-repeat;
    			background-position: 2% 40%;
    			background-color: #DD1717;
    			text-align: right;
    			color: white;
			}
			.catalog_container .product_row .product .add_product:hover{
				background-color: #E02E2E;
				cursor: pointer;
			}
			.catalog_container .product_row .product .add_product:active{
				background-color: #C61414;
			}
		</style>
	</head>
	<body>
		<div class="logo_container">
			<a href="product_catalog.php"><img src="ELYSIUM Bilgisayar Sistemleri (Transparent).png" id="logo_image" alt="logo"></a>
		</div>
		<div class="catalog_container">
			<button id="cart" onclick="window.location.href='cart.php'">Sepet (<?php $product_count=0; if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity; echo $product_count;}else echo 0; ?>)</button>
			<?php
                $row_count=0;
                while($sth=$stmt->fetch(\PDO::FETCH_ASSOC)){
                    $row_count++;
                    if($row_count%4==1) echo "<div class='product_row'>";
                    echo "<div class='product'>"
                            ."<img id='product_image' width='300px' height='300' src='data:image/jpg;base64,".base64_encode($sth['image'])."' alt='".$sth['name']."'><br />"
                            ."<label class='name'>".$sth['name']."</label>"
                            ."<label class='price'>".$sth['price']." TL "."</label>"
                            ."<form action='cart_server.php' method='post'>"
                                ."<input type='hidden' name='product' value='".$sth['product_id']."'>"
                                ."<input type='submit' class='add_product' name='add_product' value='Sepete Ekle'>"
                            ."</form>"
                        ."</div>";
                    if($row_count%4==0) echo "</div>";
                }
			?>
		</div>
	</body>
</html>