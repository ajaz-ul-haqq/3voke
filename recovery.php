<?php

$needsOTP = true;

session_start();

if(isset($_SESSION['user'])) {
    $_SESSION['readyToChangePassword'] = true;
    $needsOTP = false;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <?php include'head.php' ?>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Bitter Mobile Template">
    <meta name="keywords" content="bootstrap, mobile template, bootstrap 4, mobile, html, responsive" />
    <style>
        #alert .modal-dialog{padding:20px; margin-top:130px;}
        #registertoast .modal-dialog{padding:0px; margin-top:130px;}

    </style>
</head>

<body>

<!-- Page loading -->
<?php include 'loader.php' ?>
<!-- * Page loading -->

<!-- App Header -->
<div class="appHeader1" style="background: lightslategray">
    <div class="left"> <a href="login.php" class="icon goBack"> <i class="icon ion-md-arrow-back"></i> </a>
        <div class="pageTitle"> <?php echo $needsOTP ? 'Reset' : 'Change' ?> Password</div>
    </div>
</div>
<!-- searchBox -->

<!-- * searchBox -->
<!-- * App Header -->

<!-- App Capsule -->
<div id="appCapsule" class="pb-2" style="display: <?php echo $needsOTP ? 'block' : 'none' ?>">
    <div class="appContent1 pb-0">
        <form action="#" id="forgotform">
            <div class="inner-addon left-addon"> <i class="icon ion-md-phone-portrait"></i>
                <input type="tel" class="form-control" placeholder="Mobile Number" id="mobile" name="mobile" onKeyPress="return isNumber(event)">
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary" style="width:264px;"> Continue </button>
            </div>
        </form>
    </div>
</div>
<!-- appCapsule -->

<?php include("footer.php");?>
<div id="otpform" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content ">
            <div class="modal-body">
                <!--<button type="button" id="otpclose" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span></button>-->
                <p><strong>Plese Enter OTP</strong></p>
                <div class="pt-2">
                    <form action="#" method="post" id="otpsubmitForm">
                        <input type="tel" id="otp" name="otp" class="form-control" placeholder="Enter OTP" onKeyPress="return isNumber(event)" >
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary" style="width:264px;"> Submit OTP </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="registertoast" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content ">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <div class="text-center" id="regtoast">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="alert" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body" id="alertmessage"> </div>
            <div class="text-center pb-1">
                <a type="button" class="text-info" data-dismiss="modal">OK</a>
            </div>
        </div>
    </div>
</div>

<!-- App Capsule -->
<div id="appCapsuleForChangePassword" class="pb-2" style="display: <?php echo !$needsOTP ? 'block' : 'none' ?>">
    <div class="appContent1 pb-0">
        <form action="#" id="finalforgotform">
            <div class="inner-addon left-addon">
                <i class="icon ion-md-key"></i>
                <input type="password" name="password1" id="password1" class="form-control" placeholder="New Password">

            </div>
            <div class="inner-addon left-addon">
                <i class="icon ion-md-key"></i>
                <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm Password">
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary" style="width:264px;"> Submit </button>
            </div>
        </form>
    </div>
</div>
<!-- appCapsule -->

<!-- Jquery -->
<script src="assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="assets/js/lib/popper.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<!-- Owl Carousel -->
<script src="assets/js/plugins/owl.carousel.min.js"></script>
<!-- Main Js File -->
<script src="assets/js/app.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/forgot-password.js"></script>
</body>
</html>