<?php
session_start();

require_once '../autoload.php';
require_once  '../helpers.php';

require_once('config.php');
require_once('checksum.php');

$userid = $_SESSION['user']['id'];
$name = $_SESSION['name'];    //////////////
$mobile = $_SESSION['mobile'];     //////////
$email = $_SESSION['email'];     ////////////
$finalAmount = $_SESSION['finalamount'];   /////////

$acx = $_COOKIE['cxruser'];

$checkSum = "";
$upiuid = "";
$paramList = array();

$gateway_type = "Robotics";
$cust_Mobile = $mobile;          //cust mobile 
$cust_Email = $email;     //cust email
$orderId = uniqid().time();  //orderid
$txnAmount = $finalAmount;                     //amount
$txnNote = $userid;                  //special note
$callback_url = "https://3voke.online/autopaytmqr/txnResult.php";  //callback

if ($gateway_type == "Robotics") {
    $RECHPAY_TXN_URL = 'https://paytmqr.cosmofeed.in/order/paytm';

    $upiuid = 'paytmqr2810050501011j3g80guoq5g@paytm'; // Its Paytm Business UPI Unique ID.

    $paramList["cust_Mobile"] = $cust_Mobile;
    $paramList["cust_Email"] = $cust_Email;
}

// Create an array having all required parameters for creating checksum.
$paramList["upiuid"] = $upiuid;
$paramList["token"] = $token;
$paramList["orderId"] = $orderId;
$paramList["txnAmount"] = $txnAmount;
$paramList["txnNote"] = $txnNote;
$paramList["callback_url"] = $callback_url;

model('deposits')->insert([
    'user_id' => @$_SESSION['user']['id'], 'status' => 'INITIATED',
    'amount' => @$_SESSION['finalamount'], 'utr' => '', 'unique_id' => $orderId
]);



$checkSum = RechPayChecksum::generateSignature($paramList, $secret);
?>

<html>
<head>
<title>Gateway Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
		<form method="post" action="<?php echo $RECHPAY_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach ($paramList as $name => $value) {
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