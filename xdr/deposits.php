<?php

$wrapperContext = 'All Deposits';

$activePages = ['Payments', 'Deposits'];

$breadCrumbs = ['home', 'payments'];

require_once '../autoload.php';

include('includes/header.php');

$limit = 10;
$page = 1;
$orderBy = 'id';
$sortOrder = 'DESC';
$baseUrl = 'deposits.php?';
$deposits = model('deposits');

if (isset($_REQUEST['limit'])) {
    $limit = $_REQUEST['limit'];
}

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

if (isset($_REQUEST['filter'])) {
    $deposits->where('status', 'SUCCESS');
    $deposits = match($_REQUEST['filter']){
        'completed_today' => $deposits->where('created_at', '>', (date('Y-m-d').':00:00:00')),
        default => $deposits,
    };

    $orderBy = 'status';
    $sortOrder = 'ASC';
    $baseUrl = $baseUrl.'filter='.$_REQUEST['filter'].'&';
}

if (isset($_REQUEST['user_id'])) {
    $deposits->where('user_id', $_REQUEST['user_id']);
    $baseUrl = $baseUrl.'user_id='.$_REQUEST['user_id'].'&';
}


$total = $deposits->count();

$prevPageUrl = $page > 1 ? $baseUrl.'limit='.$limit.'&page='.$page-1 : '';
$nextPageUrl = ($page * $limit) >= $total ? '': $baseUrl.'limit='.$limit.'&page='.$page + 1;

$loggedInUser = $_SESSION['admin'];

$deposits = $deposits->select('*')->offset($limit * ($page - 1) )->limit($limit)->orderBy($orderBy, $sortOrder)->get();

include ('includes/navbar.php');
include ('includes/sidebar.php');

?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>


    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body  overflow-auto">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($deposits as $deposit) {
                                $user = model()->where('id', $deposit['user_id'])->first();

                                $class =  match($deposit['status']) {
                                    'FAILED' => 'badge-danger',
                                    'SUCCESS' => 'badge-success',
                                    default => 'badge-warning'
                                };

                                echo "<tr><td>".$deposit['id']."</td><td>".clickAbleProfile($user)."</td><td>".$deposit['amount']."</td><td>".$deposit['utr']."</td>
                          <td><span class='badge ".$class." badge'>".$deposit['status']."</span></td>
                          <td>".date('j M, Y h:i:s A',strtotime($deposit['created_at']))."</td></tr>";
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-10 pl-4">
                            <?php echo $limit * ($page - 1) + 1 . ' to '. min($total, $limit * $page) . ' out of '.$total.' records' ?>
                        </div>
                        <div class="col-md-2">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php echo !empty($prevPageUrl) ? 'disabled' : '' ?>disabled">
                                        <a class="page-link" href="<?php echo $prevPageUrl ?>" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item <?php echo !empty($nextPageUrl) ? 'disabled' : '' ?>disabled ">
                                        <a class="page-link" href="<?php echo $nextPageUrl ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include('includes/footer.php');
?>


