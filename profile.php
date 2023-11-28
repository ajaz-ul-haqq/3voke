<?php

require_once 'autoload.php';

redirectIfNotLoggedIn();

$user = $_SESSION['user'];
terminateSession();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include'head.php' ?>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <style>
        .appHeader1 {
            background-color: #fff !important;
            border-color: #fff !important;
        }
        .appContent3 {
            background-color: lightslategray !important;
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
$userid = getUserUniqueID($userid);
$walletResult = $user['balance'];
?>

<div id="spinner-div" class="pt-5">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>

<div id="responseHandler" class="pt-5">
    <span id="responseMessage" class="badge responseBadge badge-danger"> </span>
</div>


<!-- App Header -->
<div class="vcard">
    <div class="appContent3 text-white">
        <div class="row">
            <div class="col-12 mb-1">
                <b> User ID: <?php echo $userid ;?> </b>
            </div>
            <div class="col-12 mb-0">Mobile: +91 <?php echo $user['phone']; ?> </div>
            <div class="col-12 mb-1">Available Balance: ₹ <?php echo number_format($walletResult); ?></div>
            <div class="col-12">
                <a href="recharge.php" class="btn btn-sm btn-info pull-left m-0">Recharge</a>
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

            <!-- listview -->
            <p style="color: white; font-size:11px;" ><strong>______________________________________________________________________________ </p>
            <div class="accordion" id="accordionExample">
                <div class="card-header">
                    <h2 class="mb-0">
                        <a href="order.php" class="btn btn-link collapsed fa fa-list text-primary" style="font-size:16px"></i>
                            Order </a> </h2>
                </div>
                <p style="color: white; font-size:11px;" ><strong>______________________________________________________________________________ </p>
                <div class="card-header">
                    <h2 class="mb-0">
                        <a href="withdrawl.php" class="btn btn-link collapsed fa fa-money text-primary" style="font-size:16px"></i>
                            Withdrawls </a> </h2>
                </div>
                <p style="color: white; font-size:11px;" ><strong>______________________________________________________________________________ </p>
                <div class="card-header">
                    <h2 class="mb-0">
                        <a href="promotion.php" class="btn btn-link collapsed fa fa-gift text-primary" style="font-size:16px"></i>
                            Promotion </a> </h2>
                </div>

                <p style="color: white; font-size:11px;" ><strong>______________________________________________________________________________ </p>
                <div class="card-header">
                    <h2 class="mb-0">
                        <a href="recovery.php" class="btn btn-link collapsed fa fa-shield text-primary" style="font-size:16px"></i>
                            Reset Password </a> </h2>
                </div>

                <p style="color: white; font-size:11px;" ><strong>_____________________________________________________________________</p>
                <div class="card-header">
                    <h2 class="mb-0">
                        <a href="javascript:void(0); alert('coming soon')" class="btn btn-link collapsed"><i class="fa fa-download text-primary" style="font-size:16px"></i>
                            Download App </a> </h2>
                </div>

                <p style="color: white; font-size:11px;" ><strong>_____________________________________________________________________</p>
                <div class="card-header">
                    <h2 class="mb-0">
                        <a href="https://t.me/the_evoke" class="btn btn-link collapsed"><i class="fa fa-telegram text-primary" style="font-size:16px"></i>
                            Support </a> </h2>
                </div>


                <p style="color: white; font-size:11px;" ><strong>_____________________________________________________________________</p>
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0"> <a href="#" class="btn btn-link collapsed fa fa-user text-primary" type="button" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive"> About </a> </h2>
                </div>
                <div id="collapsefive" class="collapse">
                    <a href="priv.acy.php" class="sub-link"> Privacy Policy </a>
                    <a href="riskagreement.php" class="sub-link"> Risk Disclosure Agreement </a>
                </div>
            </div>


            <!-- * listview -->
        </div>
    </div>
    <!-- app Footer -->
    <div class="text-center mt-4"> <a href="handler.php?action=authLogout" class="btn btn-sm btn-danger btn-block" style="width:200px;">Logout</a> </div>
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
<script>
    $(document).ready(function () {
        $('#spinner-div').show();

        setTimeout( () => {
            $('#spinner-div').hide();
        },500)
    });
</script>
</html>