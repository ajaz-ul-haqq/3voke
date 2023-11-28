<?php

require_once 'autoload.php';

enableDebugging();
redirectIfNotLoggedIn();
$id = $_SESSION['user']['id'];
terminateSession();

$user = model()->find($id);

$name = $user['name'];
$phone = $user['phone'];
$email = $user['email'];

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
        <div class="pageTitle">Recharge</div>
    </div>
</div>
<!-- * App Header -->
<!-- App Capsule -->
<div id="appCapsule" class="rechargeOptions">
    <div class="appContent1">
        <h5 class="text-center m-2">Balance: <span>Rs <?php echo number_format(getUserBalance()); ?></span></h5>
        <form action="#" id="paymentForm" method="post" class="card-body" autocomplete="off">
            <div class="inner-addon left-addon">
                <i class="icon ion-md-wallet"></i>
                <input type="number" id="userammount" name="userammount" class="form-control" placeholder="Enter recharge amount" onKeyPress="return isNumber(event)" >
            </div>
            <div>
                <h3 class="text-bold pl-1"> * <i>Minimum amount : <b>Rs <?php echo minimumDeposit(); ?></b></i></h3>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary" style="width:264px;"> Recharge </button>
                </div>
            </div>
        </form>
        <div class="text-center mt-1"> OR</div>
        <div class="text-center mt-2">
            <button type="button" id="redeemButton" class="btn btn-info" style="width:264px;"> Redeem a Gift Card </button>
        </div>
    </div>
</div>
<div id="redeemOptions">
    <h5 class="text-center m-2">Balance: <span>Rs <?php echo number_format(getUserBalance()); ?></span></h5>
    <form action="#" id="redeemForm" method="post" class="card-body" autocomplete="off">
        <div class="inner-addon left-addon">
            <i class="icon ion-md-wallet"></i>
            <input type="text" id="giftCard" name="giftCard" class="form-control" placeholder="Enter Voucher Details"  value="" >
        </div>
        <div>
            <h3 id="validationMessage" class="text-danger text-bold pl-1"><h3>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary" style="width:264px;"> Redeem Now </button>
                    </div>
                    <div class="text-center mt-1"> OR</div>
                    <div class="text-center mt-2">
                        <button type="button" id="rechargeButton" class="btn btn-info" style="width:264px;"> Back to Recharge </button>
                    </div>
        </div>
    </form>
</div>
<div class="container d-flex justify-content-center"><a href="history.php?category=recharge"  class="badge bg-default"> Recharge Record</a></div>
<!-- appCapsule -->
<?php include("footer.php");?>
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
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $name ?>" placeholder="Enter Your Name">
                        </div>
                        <div class="inner-addon left-addon">
                            <i class="icon ion-md-phone-portrait"></i>
                            <input type="tel" id="mobile" name="mobile" class="form-control" value="<?php echo $phone ?>" placeholder="Enter Mobile Number"  onKeyPress="return isNumber(event)">
                        </div>
                        <div class="inner-addon left-addon">
                            <i class="icon ion-ios-mail"></i>
                            <input type="text" id="email" name="email" class="form-control" value="<?php echo $email ?>"  placeholder="Enter Email id">
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
<script src="assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="assets/js/lib/popper.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<!-- Owl Carousel -->
<script src="assets/js/plugins/owl.carousel.min.js"></script>
<!-- Main Js File -->
<script src="assets/js/app.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/recharge.js"></script>
</body>
</html>