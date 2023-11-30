<?php

include 'autoload.php';
session_start();
if (!isset($_SESSION['user'])) {
    redirectTo('login.php');
}

$userid = $_SESSION['user']['id'];

$page = @$_GET['page'] ?? 1;
$limit = @$_GET['limit'] ?? 10;
$category = @$_GET['category'];

$table = $category == 'withdrawal' ? 'withdrawls' : 'deposits';

$total = model($table)->where('user_id', $userid)->orderBy('id')->count();
$html = '';
$category == 'withdrawal' ? getWithdrawalForUsers($userid, $page, $limit, $html) : getDepositsForUser($userid, $page, $limit, $html);

?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'head.php';?>
    <style>
        h3 {
            font-weight:normal;
        }
        .tdtext{ font-size:16px !important; color:#090 !important; font-weight:normal; text-align:right;}
        .tdtext2{ font-size:16px !important; color:#f00 !important; font-weight:normal; text-align:right;}
        .tdtext3{ font-size:16px !important; color:#FFB400 !important; font-weight:normal; text-align:right;}
        .text small{ font-size:12px; color:#888;}
        .listView .listItem {
            padding: 0px 0px 0px 0px;
        }
        .listView .listItem .text {
            font-size: 14px;
        }
    </style>
</head>
<body>
<!-- App Header -->
<div class="appHeader1" style="<?php echo systemConfig('appHeader')?>">
    <div class="left">
        <a href="#" onClick="goBack();" class="icon goBack"> <i class="icon ion-md-arrow-back"></i> </a>
        <div class="pageTitle"> <?php echo $category == 'withdrawal'? 'Withdrawal': 'Recharge'?> History</div>
    </div>
</div>
<!-- * App Header -->
<!-- App Capsule -->
<div id="appCapsule" class="mb-5">
    <div class="appContent1 listView pt-0">
        <table class="table table-striped table-hover">
            <tbody>
            <?php echo $html?>
            </tbody>
        </table>
        <hr color="red">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $page > 1 ? '' : 'disabled'?>">
                    <a class="page-link" href="history.php?category=recharge&limit=<?php echo $limit?>&page=<?php echo($page-1)?>" tabindex="-1">Previous</a>
                </li>
                <li class="page-item <?php echo $page * $limit > $total  ? 'disabled': ''?>">
                    <a class="page-link" href="history.php?category=recharge&limit=<?php echo $limit?>&page=<?php echo($page+1)?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<div class="mb-5"></div>

<!-- appCapsule -->
<?php include("footer.php");?>
<script src="assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="assets/js/lib/popper.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<!-- Owl Carousel -->
<script src="assets/js/plugins/owl.carousel.min.js"></script>
<!-- Main Js File -->
<script src="assets/js/app.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
</body>
</html>