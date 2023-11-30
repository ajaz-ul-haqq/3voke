<?php
ob_start();
session_start();

require_once 'autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_SESSION['user'])){
    header('Location:profile.php');
}

?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'head.php' ?>

    <style>
        .btn {
            border-radius: 5px 5px 5px 5px;
            color: white;
            transition: 0.5s;
        }

    </style>
</head>

<body>


<!-- * Page loading -->

<!-- App Header -->
<div class="appHeader1" style="<?php echo systemConfig('appHeader')?>">
    <div class="left">
        <a href="javascript:void(0);" class="icon goBack">&nbsp;</a>
        <div class="pageTitle">Login</div>
    </div>


</div>


<div id="spinner-div" class="pt-5">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>

<div id="responseHandler" class="pt-5">
    <span id="responseMessage" class="badge responseBadge badge-danger"> </span>
</div>


<!-- * App Header -->
<!-- App Capsule -->
<div id="appCapsule">
    <div class="appContent1">

        <form action="#" id="loginForm" method="post" class="card-body" autocomplete="off">
            <div class="inner-addon left-addon">
                <i class="icon ion-md-phone-portrait"></i>
                <input type="tel" id="login_mobile" name="login_mobile" class="form-control" value="" placeholder="Mobile Number" onKeyPress="return isNumber(event)"  maxlength="10">
            </div>
            <div class="inner-addon left-addon">
                <i class="icon ion-md-key"></i>
                <input type="password" id="login_password" name="login_password" class="form-control" value="" placeholder="Password">
            </div>
            <input type="hidden" name="action" value="login">
            <div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-light btn-primary" style="width:264px;"> Login </button>
                </div>
                <div class="text-center mt-2">
                    <a href="signup.php" class="btn btn-light btn-primary">Sign Up</a>
                    <a href="recovery.php" class="btn btn-light btn-primary">Reset Password</a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- appCapsule -->

<?php include("footer.php");?>
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
<script src="assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="assets/js/lib/popper.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<!-- Owl Carousel -->
<script src="assets/js/plugins/owl.carousel.min.js"></script>
<!-- Main Js File -->
<script src="assets/js/app.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/account.js"></script>

</body>
</html>