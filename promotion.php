<?php

require_once 'autoload.php';
enableDebugging();
initiateSession();

if(!isset($_SESSION['user'])){
    redirectTo('login.php');
}

$userId = $_SESSION['user']['id'];

$refs = model()->where('referred_by', $userId)->get();

$str = '';
$contribution = 0;
$totalBonus = 0;
$applicableAmount = 0;

foreach ($refs as $ref) {
    $deposit = model('deposits')->where('user_id', $ref['id'])
        ->where('status', 'SUCCESS')->first();
    $amount = !empty($deposit) ? $deposit['amount'] : 0 ;

    if ($amount) {
        $x = model('orders')->where('user_id', $ref['id'])->sum('amount');
        !($x >= 2 * $amount) ? : $applicableAmount = $applicableAmount + ( $amount * 0.4 );
    }

    $bonusAmount = $amount * 0.4;
    $str = $str. "<tr><td>".$ref['phone']."</td><td>".($amount == 0 ? '---' : $amount )."</td>
       <td>".( $bonusAmount == 0 ? '---' : $bonusAmount )."</td></tr>";

    $totalBonus = $totalBonus + $bonusAmount;
    $contribution = $contribution + $amount;
}

$applicableAmount = (int) $applicableAmount - ( model('redemption')->where('user_id', $userId)->value('amount'));

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <style>
        body {
            -ms-user-select:text;
            user-select:text;
            -moz-user-select:text;
            -webkit-user-select:text
        }
        .card {
            border: 1px solid #E5E9F2;
            border-radius: 3px;
            padding: 0px;
        }
        .card .card-title {
            margin-bottom: 7px;
        }
        h3{ font-weight:normal; font-size:20px;}
        h4{ font-weight:normal; font-size:18px; color:#858585;}
        .card-body{ padding:.6rem;}
        td{ padding:3px;}
        .btn-sm {
            height: 26px;
            padding: 0px 12px;
        }
        .form-control{box-shadow:none; border-bottom:#ccc solid 1px; margin-bottom:3px;}
        #alert h4{font-size: 1rem; font-weight:bold; color:#333;}
        #alert p{font-size: 13px; margin-top:20px;}
        #alert .modal-content{border-radius:3px}
        #alert .modal-dialog{padding:20px; margin-top:130px;}

        label{ color:#999;}
        #bonus .modal-dialog{margin-top:100px;}
        #bonus .modal-footer{ border:none;}
        .dropdown-menu{ background:#fff;top: -15px;
            left: -145px; border:none;
            border-radius:0px;
            -webkit-box-shadow: 0 3px 1px -2px rgba(0, 0, 0, .2), 0 2px 2px 0 rgba(0, 0, 0, .14), 0 1px 5px 0 rgba(0, 0, 0, .12);
            box-shadow: 0 3px 1px -2px rgba(0, 0, 0, .2), 0 2px 2px 0 rgba(0, 0, 0, .14), 0 1px 5px 0 rgba(0, 0, 0, .12);}
        .appHeader1 .right{right:20px;}
        .dropdown-item {
            padding: .75rem 1.5rem;
        }
    </style>
</head>

<body>

<?php
$userid = $_SESSION['user']['id'];

include 'loader.php';
?>

<!-- App Header -->
<div class="appHeader1" style="background-color:lightslategray !important">
    <div class="left"> <a href="#" onClick="goBack();" class="icon goBack"> <i class="icon ion-md-arrow-back"></i> </a>
        <div class="pageTitle">Promotion</div>
    </div>

    <div class="right">
    </div>
</div>


<!-- App Capsule -->
<div id="appCapsule" class="pb-2">
    <div class="appContent1 pb-5">


        <h3 class="text-center m-2">Bonus: <span>₹ <span id="bms"> <?php echo $totalBonus; ?> </span></span></h3>
        <div class="text-center mb-2">
            <a data-toggle="modal" href="#bonus" data-backdrop="static" data-keyboard="false" class="btn btn-primary" style="width:160px; height:36px;">Apply to Balance</a>
        </div>


        <div class="mt-1">
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade active show" id="level1" role="tabpanel">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <div class="text-center">
                                    <h4><em>Total People</em> </h4>
                                    <h3>
                                        <?php echo count($refs); ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <div class="text-center">
                                    <h4><em>Contribution</em> </h4>
                                    <h3>₹ <?php echo $contribution; ?> </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-1">
            <div class="mt-3 border-bottom">
                <label>My Promotion Link</label>
                <p><strong><?php echo getHostLink().'/signup.php?r='.getUserUniqueId($userid); ?></strong></p>
            </div>
        </div>
    </div>

    <div class="containerrecord text-center">
        <div class="table-container">
            <table class="table table-borderless table-hover text-center">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Deposit</th>
                    <th>Bonus</th>
                </tr>
                </thead>
                <tbody>

                <?php echo $str; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="bonus" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header paymentheader" id="paymenttitle">
                <h4 class="modal-title text-dark">Redeem Bonus</h4>
            </div>
            <form action="#" method="post" id="bonusForm" autocomplete="off">
                <div class="modal-body mt-1" id="loadform">
                    <div class="row">
                        <div class="col-12">
                            <div class="inner-addon left-addon mt-3">
                                <i class="icon"><i class="fa fa-rupee"></i></i>
                                <input type="number" id="bonusammount" name="bonusammount" class="form-control" placeholder="Bonus">
                                <span class="text-danger" id="errorMessage"></span>
                            </div>
                            <span> Applicable Amount : ₹ <?php echo '<span id="applicableAmount">'.$applicableAmount.'</span>'; ?> </span><br>
                            <span> Minimum Amount : ₹ 1200 </span>
                            <input type="hidden" name="userid" id="userid" class="form-control" value="<?php echo $userid;?>">
                            <input type="hidden" name="action" id="action" class="form-control" value="bonus">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tab" id="tab" value="parity">
                <div class="modal-footer">
                    <a type="button" class="pull-left btn btn-sm closebtn" data-dismiss="modal">CANCEL</a>
                    <button type="submit" class="pull-left btn btn-sm btn-white text-info">Redeem Bonus</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
<script src="assets/js/bonus.js"></script>

</body>
</html>