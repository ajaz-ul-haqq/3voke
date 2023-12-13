<?php
include('includes/header.php');

$wrapperContext = 'Dashboard';

$activePages = ['Dashboard'];

$breadCrumbs = ['home', 'dashboard'];

$loggedInUser = $_SESSION['admin'];

$startOftheDay = (date('Y-m-d').':00:00:00');

$totalActiveUsers = users()->where('active', 1)->count();
$totalWithdrawals = withdrawals()->whereIn('status', ['"APPROVED"','"COMPLETED"']);
$totalDeposits = deposits()->where('status', 'success');
$totalOrders = orders();

$todaysUsers = users()->where('created_at', '>', $startOftheDay);
$withdrawals = withdrawals()->where('status', 'INITIATED');
$deposits = deposits()->where('status', 'success')->where('created_at','>',$startOftheDay);
$orders = orders()->where('game_id',  '>', (int) (date("Ymd") . '001'));

include ('includes/navbar.php');
include ('includes/sidebar.php');
?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                  <h5><b><?php echo number_format($withdrawals->sum('amount')).' ('.$withdrawals->count('id').')' ?></b></h5>

                <p>Pending Withdrawals </p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-alarm"></i>
              </div>
              <a href="withdrawls.php?status=pending" class="small-box-footer">View More<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h5><b><?php echo $totalWithdrawals->sum('amount').' ('.$totalWithdrawals->count('id').')' ?></b></h5>

                        <p>Approved Withdrawals </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="withdrawls.php?status=completed" class="small-box-footer">View More<i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                  <h5><b><?php echo number_format($deposits->sum('amount')).' ('.$deposits->count('id').')'; ?></b></h5>

                <p> Recent Deposits </p>
              </div>
              <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
              <a href="deposits.php?filter=completed_today" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h5><b><?php echo number_format($totalDeposits->sum('amount')).' ('.$totalDeposits->count('id').')'; ?></b></h5>

                        <p>Total Deposits </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="deposits.php?filter=completed" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
          <div class="row">
              <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-purple">
                      <div class="inner">
                          <h5><b><?php echo number_format($orders->sum('amount')).' ('.$orders->count('id').')' ?></b></h5>

                          <p> Recent Orders</p>
                      </div>
                      <div class="icon">
                          <i class="far fa-chart-bar"></i>
                      </div>
                      <a href="orders.php?filter=today" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-orange">
                      <div class="inner">
                          <h5><b><?php echo number_format($totalOrders->sum('amount')).' ('.$totalOrders->count('id').')' ?></b></h5>

                          <p> Total Orders</p>
                      </div>
                      <div class="icon">
                          <i class="fas fa-sort-amount-up"></i>
                      </div>
                      <a href="orders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-gray-dark">
                      <div class="inner">
                          <h5><b><?php echo number_format($todaysUsers->count()) ?></b></h5>

                          <p>Recent Users</p>
                      </div>
                      <div class="icon">
                          <i class="fas fa-user"></i>
                      </div>
                      <a href="users.php?registered_today=1" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-red">
                      <div class="inner">
                          <h5><b><?php echo number_format($totalActiveUsers) ?></b></h5>

                          <p>Total Users </p>
                      </div>
                      <div class="icon">
                          <i class="fas fa-users"></i>
                      </div>
                      <a href="users.php" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="card card-dark">
                      <div class="card-header">
                          <h3 class="card-title"> Recent Activities </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0" style="overflow: scroll; max-height: 800px; min-height: 800px">
                          <br>
                          <div class="timeline ml-3">

                              <?php
                              $logs = model('logs')->where('user_id', @$_SESSION['admin']['id'])->orderBy('id')->take(20);
                              foreach ($logs as $log) {
                                      $class = match ($log['action']) {
                                          'rejected_withdrawal' => 'fas fa-times-circle bg-red',
                                          'approved_withdrawal' => 'fas fa-check-circle bg-success',
                                          'user_updated' => 'fas fa-user-edit bg-primary',
                                          'customizeNumber' => 'fas fa-wrench bg-dark',
                                          'customizeStrategy' => 'fas fa-chess-rook bg-purple',
                                          default => 'fas fa-crosshairs bg-info'
                                      };

                                      echo ' <div><i class="'.$class.'"></i>
                                               <div class="timeline-item">
                                                   <span class="time"><i class="fas fa-clock"></i>'.date('j M, Y h:i:s A',strtotime($log['created_at'])).'</span>
                                                   <h3 class="timeline-header">'.$log['context'].'</h3>
                                               </div>
                                           </div>';
                                  }
                              ?>
                          </div>

                          <h6 style="text-align: center">
                              <a href='logs.php?user_id=1'> View All </a>;
                          </h6>
                          <br>
                      </div>
                      <!-- /.card-body -->
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="card card-dark">
                      <div class="card-header">
                          <h3 class="card-title"> System logs </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0"  style="overflow: scroll; max-height: 800px; min-height: 800px">
                          <br>
                          <div class="timeline ml-3">

                              <?php
                              $logs = model('logs')->orderBy('id', 'DESC')->take(20);
                              foreach ($logs as $log) {
                                  $class = match ($log['action']) {
                                      'rejected_withdrawal' => 'fas fa-times-circle bg-red',
                                      'approved_withdrawal' => 'fas fa-check-circle bg-success',
                                      'user_updated' => 'fas fa-user-edit bg-primary',
                                      'customizeNumber' => 'fas fa-wrench bg-dark',
                                      'customizeStrategy' => 'fas fa-chess-rook bg-purple',
                                      default => 'fas fa-crosshairs bg-info'
                                  };
                                  $user = model('admins')->find($log['user_id']);
                                  echo '<div><i class="'.$class.'"></i><div class="timeline-item"><span class="time"><i class="fas fa-clock"></i> '.date('j M, Y h:i:s A',strtotime($log['created_at'])).'</span>
                                       <h3 class="timeline-header">'.clickAbleProfile($user,'name', true).'</h3>
                                       <div class="timeline-body">'.$log['context'].'</div></div></div>';
                              }
                              ?>
                          </div>
                          <h6 style="text-align: center">
                              <a href='logs.php'> View All </a>;
                          </h6>
                          <br>
                      </div>
                      <!-- /.card-body -->
                  </div>
              </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- ./wrapper -->

<?php
  include('includes/footer.php')
?>
