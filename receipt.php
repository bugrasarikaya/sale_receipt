<?php
    if(!isset($_POST) || empty($_POST)){
        header("Location: post_checkout.php");
        exit();
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
    try{
        $dsn="mysql:host=localhost;dbname=receipts_db;charset=utf8";
        $conn=new PDO($dsn, "root","");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql_1="SELECT * FROM receipts WHERE receipt_id='".$_POST['receipt_id']."'";
        $stmt_1=$conn->query($sql_1);
        $sth_1=$stmt_1->fetch(\PDO::FETCH_ASSOC);
        $sql_2="SELECT * FROM customers WHERE customer_id='".$sth_1['customer_id']."'";
        $stmt_2=$conn->query($sql_2);
        $sth_2=$stmt_2->fetch(\PDO::FETCH_ASSOC);
        $sql_3="SELECT * FROM addresses WHERE address_id='".$sth_1['address_id']."'";
        $stmt_3=$conn->query($sql_3);
        $sth_3=$stmt_3->fetch(\PDO::FETCH_ASSOC);
        $sql_4="SELECT * FROM payments WHERE payment_id='".$sth_1['payment_id']."'";
        $stmt_4=$conn->query($sql_4);
        $sth_4=$stmt_4->fetch(\PDO::FETCH_ASSOC);
        $sql_5="SELECT * FROM purchases WHERE purchase_id='".$sth_1['purchase_id']."'";
        $stmt_5=$conn->query($sql_5);
        $conn=null;
    }catch(PDOException $e){
        echo "<br>",$e->getMessage();
        exit();
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Satış Fişi</title>
		<style>
            #print_button{
                float: right;
            }
            @media print{
                #print_button{
                    display: none;
                }
            }
            body{
                font-family: Arial, sans-serif;
                font-weight: normal;
                font-size: 80%;
            }
            .logo_container{
                margin-top: 20px;
				margin-right: auto;
				margin-bottom: 30px;
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
                margin-top: 20px;
                margin-right: auto;
                margin-bottom: 20px;
                margin-left: auto;
                width: 600px;
            }
            #time_table{
                margin-top: 5px;
                margin-bottom: 5px;
                width: 600px;
                border: 1px solid black;
                border-collapse: collapse;
                border-style: solid;
                text-align: left;
            }
            #time_table td{
                border: 1px solid black;
            }
            #time_table #time_title{
                padding-right: 45.5px;
            }
            #prouct_table{
                width: 600px;
                border: 1px solid black;
                border-collapse: collapse;
                border-style: solid;
                text-align: left;
            }
            #prouct_table th, td{
                border: 1px solid black;
            }
            #cost_table{
                margin-top: 5px;
                margin-left: 260px;
                margin-bottom: 5px;
                width: 340px;
                border: 1px solid black;
                border-collapse: collapse;
                border-style: solid;
                text-align: left;
            }
            #cost_table td{
                border: 1px solid black;
            }
            #cost_table #cost{
                padding-left: 4px;
            }
            #customer_information_fieldset{
                margin-top: 20px;
            }
            #address_information_fieldset{
                margin-top: 20px;
            }
            #payment_information_fieldset{
                margin-top: 20px;
            }
            .subtitle{
                float: left;
            }
            .value{
                float: right;
            }
        </style>
	</head>
	<body> 
		<button id="print_button" onClick="window.print();">Yazdır</button>
		<div class="logo_container">
			<img src="ELYSIUM Bilgisayar Sistemleri (Transparent).png" id="logo_image" alt="logo">
		</div>
		<div id="main_container">
		<table id="time_table">
			<tr>
				<td id="time_title"><b>Zaman:</b></td>
				<td><?php echo $sth_1['date']; ?></td>
			</tr>
		</table>
		<table id="prouct_table">
        	<thead>
		    	<tr>
	            	<th>Ürün</th>
		        	<th>Ürün Adedi</th>
		        	<th>Fiyat</th>
		        </tr>
		    </thead>
	     	<tbody>
				<?php 
				while($sth_5=$stmt_5->fetch(\PDO::FETCH_ASSOC)){
	                   echo "<tr>"
                                ."<td>".product_name($sth_5['product_id'])."</td>"
                                ."<td>".$sth_5['quantity']."</td>"
                                ."<td>".product_price($sth_5['product_id'])*$sth_5['quantity']." TL</td>"
	                       ."</tr>";
	                }
		          ?>
			</tbody>
		</table>
		<table id="cost_table">
			<tr>
				<td><b>Toplam:</b></td>
				<td id="cost"><?php echo $sth_1['cost']; ?> TL</td>
			</tr>
		</table>
		<fieldset id="customer_information_fieldset">
			<legend>Müşteri Bilgileri</legend>
			<label class="subtitle">İsim:</label><label class="value"><?php echo $sth_2['name']; ?></label><br />
			<hr>
			<label class="subtitle">Soyad:</label><label class="value"><?php echo $sth_2['surname']; ?></label><br />
			<hr>
			<label class="subtitle">T.C. Kimlik No:</label><label class="value"><?php echo $sth_2['personal_id']; ?></label><br />
			<hr>
			<label class="subtitle">Tel:</label><label class="value"><?php echo $sth_2['tel']; ?></label><br />
			<hr>
			<label class="subtitle">E-Posta:</label><label class="value"><?php echo $sth_2['email']; ?></label><br />
		</fieldset>
		<fieldset id="address_information_fieldset">
			<legend>Fatura Adresi Bilgileri</legend>
			<label class="subtitle">Ülke:</label><label class="value"><?php echo $sth_3['country']; ?></label><br />
			<hr>
			<label class="subtitle">İl:</label><label class="value"><?php echo $sth_3['state']; ?></label><br />
			<hr>
			<label class="subtitle">İlçe:</label><label class="value"><?php echo $sth_3['city']; ?></label><br />
			<hr>
			<label class="subtitle">Mahalle:</label><label class="value"><?php echo $sth_3['street']; ?></label><br />
			<hr>
			<label class="subtitle">Posta Kodu:</label><label class="value"><?php echo $sth_3['postal_code']; ?></label><br />
			<hr>
			<label class="subtitle">Adres:</label><label class="value"><?php echo $sth_3['address']; ?></label><br />
		</fieldset>
		<fieldset id="payment_information_fieldset">
			<legend>Ödeme Bilgileri</legend>
			<label class="subtitle">Kart Sahibinin İsmi:</label><label class="value"><?php echo $sth_4['name']; ?></label><br />
			<hr>
			<label class="subtitle">Kart Numarası:</label><label class="value"><?php echo $sth_4['card_number']; ?></label><br />
			<hr>
			<label class="subtitle">Son Kullanma Ayı:</label><label class="value"><?php echo $sth_4['expiry_month']; ?></label><br />
			<hr>
			<label class="subtitle">Son Kullanma Yılı:</label><label class="value"><?php echo $sth_4['expiry_year']; ?></label><br />
			<hr>
			<label class="subtitle">CVV:</label><label class="value"><?php echo $sth_4['cvv']; ?></label><br />
		</fieldset>
		</div>
	</body>
</html>
