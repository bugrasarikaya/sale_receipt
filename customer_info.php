<?php
    session_start();
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        header("Location: cart.php");
        exit();
    }
    if(isset($_SESSION['purchased']) || !empty($_SESSION['purchased']))header("Location: cart.php");
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
            #form_container{
                padding: 10px;
                width: 1110px;
				background: #414A4C;
                border: 5px solid #404040;
				border-radius: 3px;
				float: left;
            }
            #form_container h3{
                margin-top: 10px;
                margin-bottom: 0px;
                margin-left: 40px;
                text-align: left;
            }            
            #form_container .subtitle{
                text_align: left;
            }
            #form_container #input_name{
                width: 94%;
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
            #form_container #input_surname{
                width: 92%;
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
            #form_container #input_personal_id{
                width: 85.5%;
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
            #form_container #input_tel{
                width: 95%;
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
            #form_container #input_email{
                width: 90.6%;
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
        function control_numerical(event) {
            var character = (event.which) ? event.which : event.keyCode;
            if ((character < 48 || character > 57)){
                return false;
            }
            return true;
        }
        </script>
	</head>
	<body>
		<div class="logo_container">
			<a href="product_catalog.php"><img src="ELYSIUM Bilgisayar Sistemleri (Transparent).png" id="logo_image" alt="logo"></a>
		</div>
		<div id='main_container'>
		<form action="customer_info_server.php" method="post" id="customer_info_form">
			<div id='form_container'>
				<h3>Müşteri Bilgileri</h3>
				<hr>
				<label class='subtitle'>İsim:</label><input id='input_name' type="text" name="name" maxlength="40" required><br />
				<hr>
				<label class='subtitle'>Soyad:</label><input id='input_surname' type="text" name="surname" maxlength="40" required><br />
				<hr>
				<label class='subtitle'>T.C. Kimlik No:</label><input id='input_personal_id' type="text" name="personal_id" maxlength="11" onkeypress="return control_numerical(event)" required><br />
				<hr>
				<label class='subtitle'>Tel:</label><input id='input_tel' type="tel" name="tel" maxlength="11" onkeypress="return control_numerical(event)" required><br />
				<hr>
				<label class='subtitle'>E-Posta:</label><input id='input_email' type="email" name="email" maxlength="60" required><br />
			</div>
		</form>
		<div id='sales_summary_container'>
			<h3>Satış Özeti</h3>
			<hr>
			<label class='subtitle'>Ürün Adedi:</label><label class='value'><?php $product_count=0; foreach($_SESSION['cart'] as $product_id => $quantity) $product_count+=$quantity; echo $product_count;?></label><br/>
			<label class='subtitle'>Ödenecek Tutar:</label><label class='value'><?php $cost=0; foreach($_SESSION['cart'] as $product_id => $quantity) $cost+=product_price($product_id)*$quantity; echo $cost; ?> TL</label><br/>
			<hr id='line'>
			<button type="submit" id='continue_button' form="customer_info_form">Devam Et</button>
		</div>
		</div>
	</body>
</html>