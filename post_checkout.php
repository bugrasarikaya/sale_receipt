<?php
    session_start();
    if(!isset($_SESSION['receipt_id']) || empty($_SESSION['receipt_id'])){
        header("Location: cart.php");
        exit();
    }
    $receipt_id=$_SESSION['receipt_id'];
    unset($_SESSION['receipt_id']);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Satış Sonrası</title>
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
                margin-top: 36px;
				margin-right: auto;
				margin-bottom: auto;
				margin-left: auto;
                padding: 10px;
				transform: translateX(-8px);
                width: 600px;
				background: #414A4C;
                border: 5px solid #404040;
				border-radius: 3px;
            }
            #main_container img{
                margin-top: 10px;
                margin-left: 50%;
                transform: translateX(-50%);
            }
            #main_container h2{
                margin-top: 10px;
  				margin-right: auto;
                margin-bottom: 0px;
  				margin-left: auto;
    			width: 500px;
    			text-align: center;
            }
            #main_container #continue_button{
				margin-top: 15px;
                margin-bottom: 15px;
  				margin-left: 50%;
    			transform: translateX(-50%);
    			width: 210px;
    			height: 32px;
    			border: none;
    			border-radius: 5px;
    			background-color: #DD1717;
    			font-size: 19px;
    			text-align: center;
    			color: white;
            }
            #main_container #continue_button:hover{
                background-color: #E02E2E;
                cursor: pointer;
            }
        </style>
	</head>
	<body>
		<div class="logo_container">
			<a href="product_catalog.php"><img src="ELYSIUM Bilgisayar Sistemleri (Transparent).png" id="logo_image" alt="logo"></a>
		</div>
		<div id="main_container">
			<img src="check.png" width="300px" height="300" alt="check">
			<h2>Siparişiniz tamamlandı.</h2>
			<form action="receipt.php" method="post" target="_blank">
				<input type="hidden" name="receipt_id" value="<?php echo $receipt_id; ?>">
				<input type="submit" id="continue_button" value="Satış Fişini Göster">
			</form>
		</div>
	</body>
</html>