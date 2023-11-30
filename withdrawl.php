<?php

require_once 'autoload.php';

redirectIfNotLoggedIn();
$id = $_SESSION['user']['id'];
terminateSession();

$user = model()->find($id);

$name = $user['name'];
$phone = $user['phone'];
$email = $user['email'];
$upi = $user['upi']


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include'head.php' ?>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Brozers Mall">
    <meta name="keywords" content="Brozers Mall" />
    <style>
        h3{ font-weight:normal; font-size:14px;}
        .btn {
            border-radius: 5px 5px 5px 5px;
            border: 0.5px solid black;
            color: white;
            transition: 0.5s;
        }
        #redeemOptions
        {
            display: none;
        }
    </style>
</head>
<body>

<?php include 'loader.php' ?>
<!-- App Header -->
<div class="appHeader1" style="background-color: lightslategray !important">
    <div class="left">
        <a href="#" onClick="goBack();" class="icon goBack">
            <i class="icon ion-md-arrow-back"></i>
        </a>
        <div class="pageTitle">Request withdrawal</div>
    </div>
</div>
<!-- * App Header -->
<!-- App Capsule -->
<div id="appCapsule" class="withdrawlOptions">
    <div class="appContent1">
        <input type="hidden" id="minimumWithdrawl" name="minimumWithdrawl" value="<?php echo minimumWithdrawl(); ?>">
        <h5 class="text-center m-2">Balance: <span>Rs <?php echo number_format(getUserBalance()); ?></span></h5>
        <form action="#" id="withdrawlForm" method="post" class="card-body" autocomplete="off">
            <div class="inner-addon left-addon">
                <i class="icon ion-md-wallet"></i>
                <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter withdrawal amount" >
            </div>
            <div>
                <h3 class="text-bold pl-1"> * <i>Minimum amount : <b>Rs <?php echo minimumWithdrawl(); ?></b></i></h3>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary" style="width:264px;"> Withdraw  </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container d-flex justify-content-center"><a href="history.php?category=withdrawal" class="badge bg-default"> Withdrawal Record</a></div>
<!-- appCapsule -->
<?php include("footer.php");?>
<div id="paymentdetail" class="withdrawlModal modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <p>&nbsp;</p>
                <div class="">
                    <form action="#" method="post" id="withdrawlRequest">
                        <div class="inner-addon left-addon">
                            <i class="icon ion-md-person"></i>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Name" value="<?php echo $name ?>">
                        </div>
                        <div class="inner-addon left-addon">
                            <i class="icon ion-ios-qr-scanner"></i>
                            <input type="text" id="upi" name="upi" class="form-control" placeholder="Enter UPI details"  value="<?php echo $upi ?>">
                        </div>
                        <input type="hidden" name="amount" id="amount" value="">

                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary" style="width:264px;"> Request </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="assets/js/lib/popper.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<!-- Owl Carousel -->
<script src="assets/js/plugins/owl.carousel.min.js"></script>
<!-- Main Js File -->
<script src="assets/js/app.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/withdrawal.js"></script>
</body>
</html>