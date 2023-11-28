<?php 
ob_start();
session_start();
if($_SESSION['frontuserid']=="")
{header("location:login.php");exit();}
include("include/connection.php");
$uid_er = false;
$uid_valid = false;
$upi_id_query = mysqli_fetch_array(mysqli_query($con, "SELECT upi_id FROM `tbl_paymentsetting` WHERE `id`= '1'"));
$upi_id = $upi_id_query['upi_id'];
if(isset($_POST['manual_recharge']))
{
$userid = $_SESSION['frontuserid'];
$orderId = $_POST['orderId']; 
$amount = $_POST['amount']; 
$uid = $_POST['uid'];
$time = $date = date('d-m-Y h:i:s a', time());
/*UID Check Start*/
$uid_check = mysqli_fetch_array(mysqli_query($con, "SELECT uid FROM tbl_rchwallet WHERE uid = '$uid' limit 0,1"));
$old_uid = $uid_check['uid'];
if ($uid == $old_uid) {
$uid_er = true;
}
if($uid != $uid_check['uid']) 
{
/*IF UID IS NEW Start*/
$sql = "INSERT INTO tbl_rchwallet (userid, orderid,amount,type,actiontype,uid,time)
VALUES ('$userid', '$orderId','$amount','credit','recharge-pending','$uid','$time')";
if (!mysqli_query($con,$sql)) {
 echo '<script>
alert("something Went Wrong");
window.location.href="recharge.php";
</script>';
}
else
{
  echo '<script>
alert("Recharge Request Sent Successfully");
window.location.href="wellet_recharge.php";
</script>';
}}
/*IF UID IS NEW END*/
}
?>
<!doctype html>

<html lang="en">
    
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php include'head.php' ?>
<link rel="stylesheet" href="assets/css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Royalwin">
<meta name="keywords" content="Royalwin" />

<style>
   .mainLayout {
    width: 384px !important;
    background-color: #fafbfc;
    position: relative;
	margin: 0 auto;
}
/* media query */
@media screen and (max-width:468px){
    
    .mainLayout {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
    } 
</style>
<style>
h3{ font-weight:normal; font-size:14px;}
    .btn { background-image: linear-gradient(
#226371, #226371);
    border-radius: 5px 5px 5px 5px;
    margin: 5px 5px 5px 5px;
    /*border: 0.5px solid white;*/
    color: white;
    transition: 0.5s;
}
    .form {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
</style>
<style>

.appHeader1 {
	background-color: #fff !important;
	border-color: #fff !important;
}

* {
  box-sizing: border-box;
}
/* Create two equal columns that floats next to each other */
.column1 {
    padding-left: 15px;
    padding-right: 15px;
    width: calc(100% / 3);
    float: left;
   /* Should be removed. Only for demonstration */
}
/* Clear floats after the columns */
.row1:after {
  content: "";
  display: table;
  clear: both;
      margin-bottom: -0.50cm;
}
/* Create two equal columns that floats next to each other */
.column {
  float: center;
  width: calc(100% / 2);
   /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

.appContent3 {
	background-color: #ffb700 !important;
	border-color: #ffb700 !important;
	padding:20px;
	font-size:16px;
    border-radius: 20px 20px 20px 20px;
	box-shadow: 0 4px 8px 0 rgb(0 0 0 / 21%);
}
.user-block img {
	width: 40px;
	height: 40px;
	float: left;
	margin-right:10px;
		margin-top:-10px;
	background:#333;
}
.img-circle {
	border-radius: 50%;
}
.accordion .btn-link {
	box-shadow:none;
	padding:8px !important;
	margin:0px 0px;
	color: #333 !important;
	font-size: 17px;
	font-weight: normal;
	border-top:solid 1px #ccc;
}
.accordion .collapsed {
	border:none;
}
.accordion .show {
	border-bottom:solid 1px #ccc;
}
.accordion .sub-link {
	box-shadow:none;
	padding:8px !important;
	color: #333 !important;
	font-size: 14px;
	font-weight: normal;
	display:block;
}
.accordion .sub-link:hover {
color:#00F !important;
}
.accordion .btn-link:hover {
	background:#F5F5F5;
}
.accordion .btn-link {
	position: relative;
}
.btn3 {
   background-color: #FFD700;
    border-radius: 15px 15px 15px 15px;
    border: 1px solid white;
  padding-bottom: 4px;
  padding-top: 4px;
  padding-left: 25px;
  padding-right: 25px;
    transition: 0.5s;
    
}
 .accordion .btn-link::after {
 content: "\f105";
 color: #333;
 top: 8px;
 right: 9px;
 position: absolute;
 font-family: "FontAwesome";
 font-size:24px;
}
.btn1 {
    border-radius: 15px 0px 15px 0px;
    border: 2px solid white;
  padding-bottom: 4px;
  padding-top: 4px;
  padding-left: 25px;
  padding-right: 25px;
    transition: 0.5s;
    
}
.right{
    float:right;
}
.btn2 {
    border-radius: 5px 05px 5px 5px;
    border: 2px solid white;
  padding-bottom: 4px;
  padding-top: 4px;
  padding-left: 30px;
  padding-right: 30px;
    transition: 0.5s;
    
}

 .accordion .btn-link[aria-expanded="true"]::after {
 content: "\f106";
}
.light{
    height: 24px;
    padding: 0px 0px;
	margin: 5px 2px;
	border-radius: 20px;
width: 24px;}
.light1{
    height: 26px;
    padding: 0px 0px;
	margin: 5px 2px;
	border-radius: 20px;
width: 26px;}

.vcard {
    box-shadow:none;
}


</style>
</head>

<body>
<?php
$userid=$_SESSION['frontuserid'];
  $orderId = date('ymdhis').rand(100,10000000);
$sd1 = mysqli_query($con, "SELECT * FROM `tbl_user` WHERE `id`= $userid");
$rrq1 = mysqli_fetch_array($sd1);
$min_amount = mysqli_query($con, "SELECT rechargeamount FROM tbl_paymentsetting");
$min_amount_col = mysqli_fetch_array($min_amount);
?>

<!-- App Header -->
<div class="mainLayout">
<div class="appHeader1" style="box-shadow:none;background-color:#e0041e !important">
  <div class="left"> <a href="#" onClick="goBack();" class="icon goBack"> <i class="icon ion-md-arrow-back"></i> </a>
    <div class="pageTitle">Recharge</div>
  </div>
</div>
<div class="card-body container" style="border-top:1px solid white; ;	background:#000000;">
<div class="col text-center" style="color:white; font-size: 20px; margin:5px 10px 5px 10px;"><b>Available Balance: ₹ <span id="balance"><?php echo number_format(wallet($con,'amount',$userid), 2); ?></snap></b>
</div>
</div>

<!-- * App Header --> 

<!-- App Capsule -->

<div id="appCapsule">
    
<div class="appContent1">


<?php 
if ($uid_er) {
    echo '<div class="alert alert-danger" role="alert">
  Your recharge request has already been received.
</div>';
}
if ($uid_valid) {
    echo '<div class="alert alert-danger" role="alert">
  UID Valid
</div>';
}
 ?>
 

<div class="container p-1 border" style="margin-top:5px; background:#3b69a3;">
  <div class="text-center" style="color:white; font-size: 16px;"><b>AUTO QR PAY </b>
  </div>
  </div>
 
  <div class="container border" style="margin-top:5px;">
 <form action="#" id="paymentForm" method="post" class="card-body" autocomplete="off">
      <div class="inner-addon left-addon">
      <i class="icon ion-md-wallet"></i>
      
       
        
        <input type="number" id="userammount" name="userammount" class="form-control" placeholder="Enter recharge amount" onKeyPress="return isNumber(event)" >
      </div>
            <div>
        

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary" style="width:264px;"> PAY WITH QR </button>
        </div>
        
       </div>
    </form>
 </div>
 
 <div class="container p-1 border" style="margin-top:5px; background:#3b69a3;">
  <div class="text-center" style="color:white; font-size: 16px;"><b>MANUL UPI PAY </b>
  </div>
  </div>
 
 <div class="container border" style="margin-top:5px;">
   <input type="hidden" name="pid" value="<?php echo $pid; ?>">
   <input style="margin-top: 10px; background-color:#dbdbdb; font-weight:bold; color:red" id="myupiid" type="text" class="form line-height" value="<?php echo $upi_id ?>" readonly>
    
 <div style="text-align: center; margin-top:5px;" class="center">
 <button class="btn btn-primary" onclick="myFunction()">Copy UPI ID</button>
 
</div>

 <div class="instruction">
        <ul><u><b>*How to Pay:</b></u></ul>
        <ol>
            <li>Copy <b>UPI ID.</b></li> 
            <li>Open PhonePe/GPay/PayTm & Any UPI App and send payment VIA UPI. </li>
            <li>Go back to Recharge page and Submit Payment Amount , 12 Digit UTR number And wait for arrival.</li>
            <li>If any one  not add amount in wallet contact our <a class="instruction" href="/helpcenter" target="_blank" style="font-style:&quot;bold&quot;;font-weight: bold;color: green;">customer service</a></li>
               
        </ol>
        
        <form action="" method="post" class="card-body container p-2 border" style="margin-top:5px;" autocomplete="off">
            
      <div class="inner-addon left-addon">
      <i class="icon ion-md-wallet"></i>
        <input type="number" id="userammount" name="amount" max="99999" min="<?php echo $min_amount_col['rechargeamount'];?>" class="form" placeholder="Enter recharge amount"  onKeyPress="return isNumber(event)" required>
      </div>
   
     <div class="center">
          <input type="hidden" name="pid" value="<?php echo $pid; ?>">
          <input type="hidden" name="purpose" value="Online Payment">
          <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">
       
        <input style="margin-top: 10px;" type="text" class="form line-height" onpaste="return false;" ondrop="return false;" onKeyPress="return isNumber(event)"  name="uid" minlength="12" maxlength="12"  placeholder="12 Digit UTR No - Example : 2157XX" required>
    <div style="text-align: center; margin-top:15px;" class="center">

    <input type="submit" class="btn btn-primary"  name="manual_recharge" value="Recharge"></div>

</div>
    
     
    </form>
        
        </br>
        
    </div>
    
    
</div>
</div>
</div>

</br>
</br>
</br>

<?php include("include/footer.php");?>

<div id="paymentdetail" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <p>&nbsp;</p>
        <div class="">
        <form action="#" method="post" id="paymentdetailForm">
        <div class="inner-addon left-addon">
      <i class="icon ion-md-person"></i>
  <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Name">
      </div>
      <div class="inner-addon left-addon">
      <i class="icon ion-md-phone-portrait"></i>
        <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="Enter Mobile Number"  value="<?php echo user($con,'mobile',$userid);?>" onKeyPress="return isNumber(event)">
      </div>
      <div class="inner-addon left-addon">
      
   <input type="hidden" id="email" name="email" class="form-control" placeholder="Enter Email id"  value="<?php echo user($con,'email',$userid);?>">
      </div>
      <input type="hidden" name="finalamount" id="finalamount" value="">
      <input type="hidden" name="action" id="action" value="paydetail">
      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary" style="width:264px;"> Recharge </button>
        </div>
        </form>          
        </div>
      </div>
    </div>
  </div>
</div>


<!-- appCapsule -->

<script src="assets/js/lib/jquery-3.4.1.min.js"></script> 
<!-- Bootstrap--> 
<script src="assets/js/lib/popper.min.js"></script> 
<script src="assets/js/lib/bootstrap.min.js"></script> 
<!-- Owl Carousel --> 
<script src="assets/js/plugins/owl.carousel.min.js"></script> 
<!-- Main Js File --> 
<script src="assets/js/app.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/payment.js.php"></script>
<script type="text/javascript">
  $(document).ready(function(){
  $("#dam_return a").click(function(){
    var value = $(this).html();
        var input = $('#userammount');
        input.val(value);
  });
});
</script>
<script>
function myFunction() {
    var copyText = document.getElementById("myupiid");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard
      .writeText(copyText.value)
      .then(() => {
        alert("UPI Id Successfully Copied");
      })
      .catch(() => {
        alert("something went wrong");
      });
}
</script>
</body>
</html>