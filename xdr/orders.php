<?php

require_once '../autoload.php';

include('includes/header.php');

$wrapperContext =  'Orders list';

$breadCrumbs = ['home', 'orders'];

$activePages = ['Orders', 'All Orders'];

$limit = 15;
$page = 1;
$baseUrl = 'orders.php?';

if (isset($_REQUEST['limit'])) {
    $limit = $_REQUEST['limit'];
}

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$executions = orders();

if(isset($_REQUEST['user_id'])) {
    $executions->where('user_id', $_REQUEST['user_id']);
    $baseUrl = $baseUrl.'user_id='.$_REQUEST['user_id'].'&';
}

if (isset($_REQUEST['filter']) && $_REQUEST['filter'] === 'today') {
    $executions->where('game_id', '>', (int) (date("Ymd") . '001'));
    $baseUrl = $baseUrl.'filter=today&';
}

$total = $executions->count();

$prevPageUrl = $page > 1 ? $baseUrl.'limit='.$limit.'&page='.$page-1 : '';
$nextPageUrl = ($page * $limit) >= $total ? '': $baseUrl.'limit='.$limit.'&page='.$page + 1;

$orders = $executions->select('*')->offset($limit * ($page - 1) )->orderBy('id')->limit($limit)->get();

include('includes/navbar.php');
include('includes/sidebar.php');

?>

<div class="content-wrapper">
    <?php include('includes/wrapper.php'); ?>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body  overflow-auto">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>GameId</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Select</th>
                                <th>Amount</th>
                                <th>Outcomes</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                              foreach ($orders as $order) {
                                  $user = model()->where('id', $order['user_id'])->first();
                                  $result =  match ((int)$order['status']) {
                                      1 => ['class' => 'badge-success', 'text' => '+'.$order['amount'] * 1.9 ],
                                      2 => ['class' =>'badge-danger', 'text' => '-'. $order['amount'] ],
                                      3 => ['class' =>'badge-primary', 'text' => '+'. $order['amount'] * 1.45 ],
                                      4 => ['class' =>'badge-success', 'text' => '+'. $order['amount'] * 8.55 ],
                                      default => ['class' => 'badge-secondary', 'text' => 'awaiting' ],
                                  };

                                  $status =  match( (int) $order['status'] ) {
                                      0 => ['class' => 'badge-warning', 'text' => 'pending', 'after' => 'badge-secondary'],
                                      1 => ['class' =>'badge-primary', 'text' => 'completed', 'after' => 'badge-success'],
                                      default => ['class' =>'badge-primary', 'text' => 'completed', 'after' => 'badge-danger']
                                  };

                                  $statusText = "<span class ='badge ".$status['class']."'> ".$status['text']." </span>";


                                  echo "<tr><td>".$order['id']."</td><td>".$order['game_id']."</td><td>".clickAbleProfile($user)."</td><td>".$order['type']."</td><td>".$order['selection']."</td>
                          <td><span class='badge badge-info'> ".$order['amount']." </span></td>
                          <td><span class='badge ".$result['class']." badge'> ".$result['text']." </span></td><td>". $statusText ."</td>
                          <td>".date('h:i:s A',strtotime($order['created_at']))."</td></tr>";
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
include('includes/footer.php')
?>
