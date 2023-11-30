<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
if (!isset($_SESSION['user'])) {
    redirectTo('login.php');
}


require_once 'autoload.php';

include 'records.php';

?>
<!doctype html>
<html lang="en">
<head>
    <?php include'head.php' ?>
    <style>
        .appHeader1 {
            background-color: #fff !important;
            border-color: #fff !important;
        }
        .appContent3 {
            <?php echo systemConfig('appHeader')?>;
            border-color: #2196f3 !important;
            padding:12px;
            border-radius:3px;
            font-size:16px;
        }
        .user-block img {
            width: 40px;
            height: 40px;
            float: left;
            margin-right:10px;
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
            font-size: 16px;
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
            font-size: 20px;
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
        .accordion .btn-link::after {
            content: "\f107";
            color: #333;
            top: 8px;
            right: 9px;
            position: absolute;
            font-family: "FontAwesome";
            font-size:30px;
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

    </style>
</head>

<body>
<?php

$userid = $_SESSION['user']['id'];
$user = model()->find($userid);
$userid = getUserUniqueId($userid);
$walletResult = $user['balance'];

$orders = model('orders')->where('user_id', $user['id'])->orderBy('id')->get();

?>

<!-- App Header -->
<div class="vcard">
    <div class="appContent3 text-white">
        <div class="row">
            <div class="col-5 mb-1">
                <b>Orders</b>
            </div>
            <div class="col-7 mb-1">
                <b> User ID: <?php echo $userid ;?> </b>
            </div>
        </div>
    </div>
</div>
</div>
<!-- searchBox -->

<!-- * searchBox -->
<!-- * App Header -->

<!-- App Capsule -->
<div class="appContent1 mb-5">
    <div class="contentBox long mb-3">
        <div class="contentBox-body card-body">
            <?php echo appendMyRecordsToResponse($orders, 'parity'); ?>
        </div>
    </div>
    <!-- app Footer -->
    <div class="text-center mt-4"> <a href="logout.php" class="btn btn-sm btn-primary" style="width:200px;">Logout</a> </div>
    <!-- * app Footer -->

</div>
<!-- appCapsule -->
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