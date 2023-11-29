<?php

$wrapperContext = 'All Withdrawls';

$activePages = ['Payments', 'Withdrawls'];

$breadCrumbs = ['home', 'payments'];

require_once '../autoload.php';

include('includes/header.php');

$withdrawals = model('withdrawls');

$limit = 10;
$page = 1;
$orderBy = 'id';
$sortOrder = 'DESC';
$baseUrl = 'withdrawls.php?';

if (isset($_REQUEST['limit'])) {
    $limit = $_REQUEST['limit'];
}


if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

if (isset($_REQUEST['status'])) {
    $status = true;
    $status = match($_REQUEST['status']){
        'pending' =>  ['"INITIATED"'],
        'completed' => ['"APPROVED"','"COMPLETED"'],
        default => false,
    };

    if (is_array($status)) {
        $withdrawals->whereIn('status', $status);
        $orderBy = 'status';
        $sortOrder = 'ASC';
        $baseUrl = $baseUrl.'status='.$_REQUEST['status'].'&';
    }
}

if (isset($_REQUEST['user_id'])) {
    $withdrawals->where('user_id', $_REQUEST['user_id']);
    $baseUrl = $baseUrl.'user_id='.$_REQUEST['user_id'].'&';
}

$total = $withdrawals->count();
$prevPageUrl = $page > 1 ? $baseUrl.'limit='.$limit.'&page='.$page-1 : '';
$nextPageUrl = ($page * $limit) >= $total ? '': $baseUrl.'limit='.$limit.'&page='.$page + 1;

$loggedInUser = $_SESSION['admin'];

$withdrawls = $withdrawals->select('*')->offset($limit * ($page - 1) )->limit($limit)->orderBy($orderBy, $sortOrder)->get();

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
                                <th>Status</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($withdrawls as $withdrawl) {
                                $user = model()->where('id', $withdrawl['user_id'])->first();

                                $class =  match($withdrawl['status']) {
                                    'APPROVED' => 'badge-primary',
                                    'REJECTED' => 'badge-danger',
                                    'COMPLETED' => 'badge-success',
                                    default => 'badge-warning'
                                };

                                echo "<tr><td>".$withdrawl['id']."</td><td>".clickAbleProfile($user)."</td><td>".$withdrawl['amount']."</td>
                          <td><span class='badge ".$class." badge'>".$withdrawl['status']."</span></td>
                          <td>".date('j M, Y h:i:s A',strtotime($withdrawl['created_at']))."</td>
                          <td><a href='withdrawl-info.php?id=".$withdrawl['id']."'><button class='btn btn-sm btn-light btn-outline-dark'> View </button></a></td></tr>";
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