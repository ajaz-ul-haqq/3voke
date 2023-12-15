<?php
error_reporting(0);
require_once('lib/Config_RechPay.php');
require_once('lib/RechPayChecksum.php');

$checkSum = "";
$upiuid = "";
$paramList = array();

$gateway_type = "Robotics";
$cust_Mobile = $_POST['cust_Mobile'];
$cust_Email = $_POST['cust_Email'];
$orderId = "CXRSMM".uniqid();
$txnAmount = $_POST['txnAmount'];
$txnNote = $_POST['txnNote'];
$callback_url = "https://pbsmm.store/trial/txnResult.php";

if($gateway_type=="Advanced"){
    
$RECHPAY_TXN_URL='https://pbsmm.store/order/payment';

$upiuid = 'paytmqr2810050501015xg0ntj46au0@paytm'; // Its Your Self UPI ID.

}else if($gateway_type=="Robotics"){

$RECHPAY_TXN_URL='https://pbsmm.store/order/paytm';

$upiuid = 'paytmqr2810050501015xg0ntj46au0@paytm'; // Its Paytm Business UPI Unique ID.

$paramList["cust_Mobile"] = $cust_Mobile;
$paramList["cust_Email"] = $cust_Email;

}else if($gateway_type=="Normal"){
    
$RECHPAY_TXN_URL='https:/pbsmm.store/order/process';   

$upiuid = 'paytmqr2810050501015xg0ntj46au0@paytm';  // Its UPI Unique ID, (Url:http://example.com/UPIsAccounts).

}

// Create an array having all required parameters for creating checksum.
$paramList["upiuid"] = $upiuid;
$paramList["token"] = $token;
$paramList["orderId"] = $orderId ;
$paramList["txnAmount"] = $txnAmount;
$paramList["txnNote"] = $txnNote;
$paramList["callback_url"] = $callback_url;

$checkSum = RechPayChecksum::generateSignature($paramList,$secret);
?>
<html>
<head>
<title>Gateway Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page⚡...</h1></center>
		<form method="post" action="<?php echo $RECHPAY_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="checksum" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>
</html>
