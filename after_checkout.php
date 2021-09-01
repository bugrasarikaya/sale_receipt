<?php
    session_start();
    if(!isset($_SESSION['receipt_id']) || empty($_SESSION['receipt_id'])){
        header("Location: cart_page.php");
        exit();
    }
    $receipt_id=$_SESSION['receipt_id'];
    unset($_SESSION);
    session_destroy();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Satış Sonrası</title>
	</head>
	<body>
		<img src="check.png" alt="check">
		<h2>Siparişiniz tamamlandı.</h2>
		<form action="receipt.php" method="post">
			<input type="hidden" value="<?php echo $receipt_id; ?>">
			<input type="submit" value="Satış Fişini Göster">
		</form>
	</body>
</html>