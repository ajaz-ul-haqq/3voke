<?php
include('includes/header.php');

$wrapperContext = 'Dashboard';

$activePages = ['Dashboard'];

$breadCrumbs = ['home', 'dashboard'];

$loggedInUser = $_SESSION['admin'];

$startOftheDay = (date('Y-m-d').':00:00:00');

$totalActiveUsers = model()->where('active', 1)->count();
$totalWithdrawals = model('withdrawls')->whereIn('status', ['"APPROVED"','"COMPLETED"']);
$totalDeposits = model('deposits')->where('status', 'success');
$totalOrders = model('orders');

$todaysUsers = model()->where('created_at', '>', $startOftheDay);
$withdrawals = model('withdrawls')->where('status', 'INITIATED');
$deposits = model('deposits')->where('status', 'success')->where('created_at','>',$startOftheDay);
$orders = model('orders')->where('game_id',  '>', (int) (date("Ymd") . '001'));

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
                  <h5><b><?php echo $withdrawals->sum('amount').' ('.$withdrawals->count('id').')' ?></b></h5>

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
                  <h5><b><?php echo $deposits->sum('amount').' ('.$deposits->count('id').')'; ?></b></h5>

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
                        <h5><b><?php echo $totalDeposits->sum('amount').' ('.$totalDeposits->count('id').')'; ?></b></h5>

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
                          <h5><b><?php echo $orders->sum('amount').' ('.$orders->count('id').')' ?></b></h5>

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
                          <h5><b><?php echo $totalOrders->sum('amount').' ('.$totalOrders->count('id').')' ?></b></h5>

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
                          <h5><b><?php echo $todaysUsers->count() ?></b></h5>

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
                          <h5><b><?php echo $totalActiveUsers ?></b></h5>

                          <p>Total Users </p>
                      </div>
                      <div class="icon">
                          <i class="fas fa-users"></i>
                      </div>
                      <a href="users.php" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
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
