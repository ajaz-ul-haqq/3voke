<?php

require_once 'autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['user'])) {
    header("location:login.php");
    exit();
}

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

$appHeader = systemConfig('appHeader');

?>

<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Evoke </title>
  <link rel="stylesheet" href="assets/css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="description" content="Bitter Mobile Template">
  <meta name="keywords" content="bootstrap, mobile template, bootstrap 4, mobile, html, responsive" />
  <style>
.appHeader1 {
    <?php echo $appHeader ?>;
	border-color: #f44336 !important;
}
.card {
	border-radius:0px;
	padding:10px !important;
}
h3 {
	font-weight:normal;
	font-size:18px;
}
.razorpay-payment-button {
	padding: 10px 50px;
	color: #fff;
    <?php echo $appHeader; ?>;
	font-weight: 600;
	font-size: 14px;
	border: 1px solid #ff2e17;
	text-transform:uppercase;
}
.razorpay-payment-button:hover {
	color: #fff;
	background-color: #f33076;
	border-color: #f2246e;
	cursor:pointer;
}
</style>
  
  </head>

  <body>

  <!-- Page loading -->
  <div class="loading" id="loading">
    <div class="spinner-grow"></div>
  </div>
  <!-- * Page loading --> 

  <!-- App Header -->
  <div class="appHeader1">
    <div class="left"> <a href="#" onClick="goBack()" class="icon goBack"> <i class="icon ion-md-arrow-back"></i> </a>
      <div class="pageTitle">Pay Now</div>
    </div>
  </div>
  <!-- * App Header --> 

  <!-- App Capsule -->
  <div id="appCapsule">
    <div class="appContent">
      <div class="sectionTitle3"> 
        
        <!-- post list -->
        <div class="">
          <div class="row"> 
            <!-- item -->
            <div class="col-12 pright">
              <div class="vcard card mt-5">
                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th colspan="2" style="text-align:center; font-size:18px; border-top:none;">Payment Detail</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Name </td>
                      <td><?php echo $_SESSION['name'];?></td>
                    </tr>
                    <tr>
                      <td>Mobile </td>
                      <td><?php echo $_SESSION['mobile'];?></td>
                    </tr>
                    <tr>
                      
                    <tr>
                      <td>Payable Amount </td>
                      <td>₹ <?php echo number_format($_SESSION['finalamount'],2);?></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align:center; font-size:18px;">
                      
                        
                        <?php if(isset($formError)) { ?>
                        <span style="color:red">Please fill all mandatory fields.</span> <br/>
                        <br/>
                        <?php } ?>
                        <form action="autopaytmqr/autopaytmqrpay.php" method="post">
   <input type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $_SESSION['user']['id'];?>">
  <input type="hidden" id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" value="Retail">
  <input type="hidden" id="CHANNEL_ID" name="CHANNEL_ID" value="WEB">
  <input type="hidden" title="TXN_AMOUNT" name="TXN_AMOUNT" value="<?php echo $_SESSION['finalamount'];?>">
  <input type="submit" class="razorpay-payment-button" value="Pay ₹ <?php echo number_format($_SESSION['finalamount'],2);?> With QR" />
</form>
</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- * post list --> 
        <!-- * listview --> 
        
      </div>
    </div>
  </div>
  <div class="mb-1"></div>
  <?php include("footer.php");?>
  <!-- Jquery --> 
  <script src="assets/js/lib/jquery-3.4.1.min.js"></script> 
  <!-- Bootstrap--> 
  <script src="assets/js/lib/popper.min.js"></script> 
  <script src="assets/js/lib/bootstrap.min.js"></script> 
  <!-- Owl Carousel --> 
  <script src="assets/js/plugins/owl.carousel.min.js"></script> 
  <!-- Main Js File --> 
  <script src="assets/js/app.js"></script>
</body>
</html>