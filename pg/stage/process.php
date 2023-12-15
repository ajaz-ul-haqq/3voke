<?php
session_start();
session_regenerate_id();
require_once('../system/function.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo webdata('company_name');?> | Partner</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../assets/dist/css/adminx.css" media="screen" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="icon" href="<?php echo webdata('web_fav');?>" type="image/*" />
	<script src="../assets/dist/js/historry.js"></script>
	<script src="../assets/dist/js/sweetalert.min.js"></script>
<style>
.navbar-brand-image {
    width: 3.875rem;
    height: 1.875rem;
}    
.brand-logo{
   background-image: url('../images/brand.png');
   background-size: contain; 
   background-repeat: no-repeat;
   background-position: 
   center;
   height: 40px; width: 120px 
    
}

.small-logo {
    /* height: 60px; */
    width: 150px;
}

.adminx-container .navbar {
    font-size: .875rem;
    /* background-color: #000; */
    height: 3.5rem;
    padding: 0;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    background-image: linear-gradient(90deg, #085bac, #11c4cb);
}
.adminx-sidebar {
    /* background: #fff; */
    position: fixed;
    width: 260px;
    top: 3.5rem;
    bottom: 0;
    left: 0;
    z-index: 1040;
    -webkit-box-shadow: 1px 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 1px 1px 1px 0 rgba(0,0,0,.1);
    background-image: linear-gradient(180deg, #095fae, #11c4cb);
}
.sidebar-nav-link {
    padding: .5rem 1.5rem;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    color: #ffffff;
}
.sidebar-nav-link.active {
    color: #ffffff;
}
.sidebar-sub-nav {
    list-style-type: none;
    margin: 0;
    padding: .5rem 0;
    font-size: .875rem;
    background-image: linear-gradient(180deg, #095fae, #11c4cb);
}
a:hover {
  color: white;
}
.card{
border-radius: 5px;	
}
.sp-background {
  background: #0857ab;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;

}
.card-nblue {
 background: #011f3f;	
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #0e98be;
}

.bg-mix{
  background: linear-gradient(#0857ab,#11c9cc);	
}
.table-hover tbody tr:hover {
    background-color: #011f3f;
    color: white;
}
</style>

</head>
<body class="sp-background">
<div class="p-3">
<div class="container pl-5 pr-5">	
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
if(isset($_POST['upiuid'])&& 
!empty($_POST['token'])&& 
!empty($_POST['orderId'])&& 
!empty($_POST['txnAmount'])&& 
!empty($_POST['txnNote'])&&
!empty($_POST['callback_url'])&& 
!empty($_POST['checksum']) ){

$upiuid = safe_str($_POST['upiuid']);
$token = strip_tags($_POST['token']);
$orderId = safe_str($_POST['orderId']);
$txnAmount = safe_str($_POST['txnAmount']);
$txnNote = safe_str($_POST['txnNote']);
$callback_url = strip_tags($_POST['callback_url']);
$checksum = $_POST['checksum'];

$res = sql_query("SELECT * FROM `tb_partner` WHERE token='".$token."' AND status='active' ");
$result = sql_fetch_array($res);
if(sql_num_rows($res)>0 && $result['token']==$token){

$txn_query = sql_query("SELECT * FROM `tb_transactions` WHERE client_orderid='".$orderId."' ");
if(sql_num_rows($txn_query)==''){
$paramList = array();
$paramList["upiuid"] = $upiuid;
$paramList["token"] = $token;
$paramList["orderId"] = $orderId;
$paramList["txnAmount"] = $txnAmount;
$paramList["txnNote"] = $txnNote;
$paramList["callback_url"] = $callback_url;	
require_once('../system/checksum.php');
$verifySignature = RechPayChecksum::verifySignature($paramList, $result['secret'], $checksum);
if($verifySignature){
$upi_query = sql_query("SELECT * FROM `tb_upis` WHERE upi_uid='".$upiuid."' AND uid='".$result['id']."' AND status='ACTIVATED' ");
$upi_result = sql_fetch_array($upi_query);	

if(sql_num_rows($upi_query)>0){
$txn_ref_id = GenRandomString().time();	
$_SESSION['muid'] = $result['id'];
$_SESSION['auth_token'] = $result['token'];
$_SESSION['txn_ref_id'] = $txn_ref_id;
$_SESSION['upi_id'] = $upi_result['upi_id'];
$_SESSION['client_orderid'] = $orderId;	
echo "<script>
setTimeout(function(){ 
document.getElementById(\"qrcode\").innerHTML = '';
GenerateQR('".$upi_result['upi_id']."', '".$upi_result['upi_name']."', '".$txnAmount."', '".$txn_ref_id."', '".$txnNote."'); 
var upilink = document.getElementById(\"qrcode\").title;
document.getElementById(\"upilink\").href = upilink;
}, 1000);
</script>";	

$json_string = json_encode(array(
"txnStatus"=>'TXN_SUCCESS', 
"resultInfo"=>'Txn Success',
"orderId"=>$orderId,
"txnAmount"=>$txnAmount,
"txnId"=>GenRandomString(12),
"bankTxnId"=>rand(0000,9999),
"paymentMode"=>'UPI',
"txnDate"=>date_time("Y-m-d h:i:s A"),
"utr"=> '0000'.rand(00000000,99999999),
"sender_vpa"=>'demosender@bankupi',
"sender_note"=>$txnNote,
"payee_vpa"=>webdata("upi_prefix").rand(0000,9999).webdata("upi_bank"),
));	

$hash = hash_encrypt($json_string, $result['secret']);

$checksum = RechPayChecksum::generateSignature($json_string,$result['secret']);

$html = '
<form id="formSubmit" action="'.$callback_url.'" method="post" style="display:none;">
<input type="hidden" id="status" name="status">
<input type="hidden" id="message" name="message">
<input type="hidden" id="hash" name="hash">
<input type="hidden" id="checksum" name="checksum">
</form>
<script type="text/javascript" src="../assets/dist/js/txnStatusTest.js"></script>';
echo $html;
}else{
$html = '
<h2 style="color:white" class="text-center">Please do not refresh this page...</h2>
<form id="formSubmit" action="'.$callback_url.'" method="post" style="display:none;">
<input type="hidden" name="status" value="FAILED" >
<input type="hidden" name="message" value="upiuid is invalid or not active" >
<input type="hidden" name="hash" value="false">
<input type="hidden" name="checksum" value="false">
</form>
<script type="text/javascript">
setTimeout(function(){ 
document.getElementById("formSubmit").submit();
}, 1000);
</script>
';	
echo $html;
exit();	
}
	
	
}else{
$html = '
<h2 style="color:white" class="text-center">Please do not refresh this page...</h2>
<form id="formSubmit" action="'.$callback_url.'" method="post" style="display:none;">
<input type="hidden" name="status" value="FAILED" >
<input type="hidden" name="message" value="Checksum Mismatch" >
<input type="hidden" name="hash" value="false">
<input type="hidden" name="checksum" value="false">
</form>
<script type="text/javascript">
setTimeout(function(){ 
document.getElementById("formSubmit").submit();
}, 1000);
</script>
';	
echo $html;	
exit();	
}


}else{
$html = '
<h2 style="color:white" class="text-center">Please do not refresh this page...</h2>
<form id="formSubmit" action="'.$callback_url.'" method="post" style="display:none;">
<input type="hidden" name="status" value="FAILED" >
<input type="hidden" name="message" value="This Order Id is Already Taken" >
<input type="hidden" name="hash" value="false">
<input type="hidden" name="checksum" value="false">
</form>
<script type="text/javascript">
setTimeout(function(){ 
document.getElementById("formSubmit").submit();
}, 1000);
</script>
';	
echo $html;		
exit();	
}



}else{
$html = '
<h2 style="color:white" class="text-center">Please do not refresh this page...</h2>
<form id="formSubmit" action="'.$callback_url.'" method="post" style="display:none;">
<input type="hidden" name="status" value="FAILED" >
<input type="hidden" name="message" value="Unauthorized Access or Token Is Invalid" >
<input type="hidden" name="hash" value="false">
<input type="hidden" name="checksum" value="false">
</form>
<script type="text/javascript">
setTimeout(function(){ 
document.getElementById("formSubmit").submit();
}, 1000);
</script>
';	
echo $html;		
exit();	
}

	
}else{
echo '<h2 style="color:white" class="text-center">Parameter Missing<br>Redirect...</h2>';
redirect(webdata('socket').base_url(),'2000');		
exit();	
}

}else{
echo '<h2 style="color:white" class="text-center">Unauthorized Access<br>Redirect...</h2>';
redirect(webdata('socket').base_url(),'2000');		
exit();	
}
?>

<!--h4 class="text-white pb-3"><b><?php echo $result['company_name'];?></b></h4-->
<div class="row justify-content-center">
<div class="col-md-8 card p-4">	
<div class="row">
<!--div class="col-md-12">
<div><a href="<?php echo $callback_url;?>" class="text-dark" style="text-decoration: none;"><i class="fa fa-reply"></i> Go Back</a></div>
<hr>
</div--> 
<div class="col-md-8">
<div class="text-dark">
<a href="<?php echo $callback_url;?>" class="text-dark" style="text-decoration: none;"><i class="fa fa-reply"></i> Go Back</a> 
<b>(<?php echo $result['company_name'];?>)</b><br><span>Order Id: <?php echo $orderId;?></span></div>
</div> 
<div class="col-md-4 text-right">
<div class="text-dark">Total Amount <i class="fas fa-rupee-sign fa-sm"></i><b><?php echo $txnAmount;?></b></div>
</div>  

<div class="col-md-12 text-center">
<hr>
<div class="text-dark"><b>Scan QR code using BHIM or your preferred UPI app</b></div>
<div class="col-md-12 text-center mt-1">
<div class="text-center">
<img src="../assets/img/gpay.png" alt="gpay" height="20px"> 
<img src="../assets/img/paytm.png" alt="gpay" height="20px">
<img src="../assets/img/phonepe.png" alt="gpay" height="20px">
<img src="../assets/img/bhim_logo.png" alt="gpay" height="20px">
<img src="../assets/img/amazonpay.png" alt="gpay" height="20px">
</div>
<div class="mt-2" id="qrcode">
<img src="../assets/img/loading.cc387905.gif" alt="" width="200">
</div>
<button href="#" id="upilinkb" onclick="TxnStatus('failed','','')" class="btn bg-danger text-white btn-sm mt-2">Failed</button>
<button href="#" id="upilink" onclick="TxnStatus('success','<?php echo $hash;?>','<?php echo $checksum;?>')" class="btn bg-primary text-white btn-sm mt-2">Success</button><br>
<span class="text-center font-weight-bold">This QR code will expire in <span id="upitimer"></span></span></p> 
</div> 
<div class="col-md-12 text-center mt-0">
<img src="../assets/img/rectangle.png" alt="" style="width: 100%;">
</div>
</div>
</div>
</div>
</div>
</div>
</div>

    <!-- If you prefer jQuery these are the required scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="../assets/dist/js/vendor.js"></script>
    <script src="../assets/dist/js/adminx.js"></script>
	<script src="../assets/dist/js/custom-new.js"></script>
	<script src="../assets/dist/js/qrcode.min.js"></script>
	<script>upiCountdown("upitimer",005,00,'<?php echo $callback_url;?>');</script>
	
  </body>
</html> 