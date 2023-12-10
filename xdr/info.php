<?php

$wrapperContext = 'User Info';

$activePages = ['User Directory', 'All User'];

$breadCrumbs = ['home', 'users', 'info'];

require_once '../autoload.php';
include('includes/header.php');

$loggedInUser = $_SESSION['admin'];


if( ! isset($_REQUEST['id'])) {
  header('Location:users.php');
}

$id = $_REQUEST['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = model();
  $email = $_POST['email'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $status = $_POST['status'];
  $upiId = $_POST['upi'];

  $user = model()->find($id);

  foreach ($user as $item => $value) {
      if(isset($_POST[$item]) && $_POST[$item] != $value){
          $valuesToUpdate[$item] = $_POST[$item];
      }
  }

  if(!empty($valuesToUpdate)) {
      model()->where('id', $id)->update($valuesToUpdate);
      foreach ($valuesToUpdate as $key => $value) {
          createLog('user_updated', 'Updated user <b>'.$user['phone'].'</b>, Set <b>'.$key.'</b> as '.$value.' from <b>'.$user[$key].'</b>');
      }
  }

  $successMessage = '<div class="row">
        <div class="alert alert-success div-s alert-dismissible col-md-10 ml-3">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> User updated successfully !</h5>
        </div>
      </div>';
}

$user = new \App\Models\Model('users');
$user = $user->where('id', $id)->first();

$isActive = (bool) $user['active'];

$deposits = new \App\Models\Model('deposits');
$deposits = $deposits->where('user_id', $id)->where('status', 'LIKE', 'SUCCESS')
  ->pluck('amount')->toArray();

$withdrawls = new \App\Models\Model('withdrawls');
$withdrawls = $withdrawls->where('user_id', $id)
  ->where('status', 'LIKE', 'COMPLETED')->orderBy('id')
  ->pluck('amount')->toArray();

$latestWithdrawls = (new \App\Models\Model('withdrawls'))
  ->where('user_id', $id)->orderBy('id')->take(10);

$latestDeposits = (new \App\Models\Model('deposits'))
    ->orderBy('id')
  ->where('user_id', $id)->take(10);


$referrals = new \App\Models\Model('users');
$referrals = $referrals->where('referred_by', $id)->pluckToArray('id');

$referredUsers = new \App\Models\Model('users');
$referredUsers = $referredUsers->where('referred_by', $id)->orderBy('id')->take(10);

$referralDeposits = (new \App\Models\Model('deposits'))
  ->whereIn('user_id', $referrals)->pluckToArray('amount');

$executions = model('orders')->where('user_id', $id)->orderBy('id', 'DESC')->take(10);

$totalDeposits = $totalWithdrawls = $totalReferralDeposits = 0;

foreach ($deposits as $deposit) {
  $totalDeposits = $totalDeposits + $deposit;
}

foreach ($withdrawls as $withdrawl) {
  $totalWithdrawls = $totalWithdrawls + $withdrawl;
}

foreach ($referralDeposits as $referralDeposit){
  $totalReferralDeposits = $totalReferralDeposits + $referralDeposit;
}

include ('includes/navbar.php');
include ('includes/sidebar.php');
?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>

    <?php echo $successMessage ?? '' ?>

    <section class="content">
        <div class="row">
          <div class="col-md-4">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"> Statistics </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped table-hover">
                  <tbody>
                  <tr>
                    <td>1.</td>
                    <td>Available Balance</td>
                    <td>
                      <span class="badge badge-primary badge">
                        <?php echo $user['balance']; ?>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>2.</td>
                    <td>Deposits</td>
                    <td>
                      <span class="badge badge-primary badge">
                        <?php echo $totalDeposits; ?>
                      </span>
                      <span class="badge badge-danger badge">
                        <?php echo count($deposits); ?>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>3.</td>
                    <td>Withdrawls</td>
                    <td>
                      <span class="badge badge-primary badge">
                        <?php echo $totalWithdrawls; ?>
                      </span>
                      <span class="badge badge-danger badge">
                        <?php echo count($withdrawls); ?>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td> Contributions </td>
                    <td>
                       <span class="badge badge-primary badge">
                        <?php echo $totalReferralDeposits; ?>
                      </span>
                      <span class="badge badge-danger badge">
                        <?php echo count($referrals); ?>
                      </span>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Last 10 withdrawls </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped table-hover">
                  <tbody>  <?php
                  $count = 1;
                  foreach ($latestWithdrawls as $latestWithdrawl) {
                    $class =  match($latestWithdrawl['status']) {
                      'APPROVED' => 'badge-primary',
                      'REJECTED' => 'badge-danger',
                      'COMPLETED' => 'badge-success',
                      default => 'badge-warning'
                    };

                    echo "<tr><td>".$count."</td><td>".$latestWithdrawl['amount']."</td>
                          <td><span class='badge ".$class." badge'>".$latestWithdrawl['status']."</span></td>
                          <td>".date('j M, Y h:i:s A',strtotime($latestWithdrawl['created_at']))."</td></tr>";

                    $count++;
                  }

                  if (empty($latestWithdrawls)) {
                    echo "<tr><td> No records found.. </td></tr>";
                  }

                  if (!empty($latestWithdrawls)) {
                      echo "<tr><th colspan='4' class='text-center'><a href='withdrawls.php?user_id=".$id."'> View All. </a></th></tr>";
                  }

                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Last 10 Deposits </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped table-hover">
                  <tbody>  <?php
                  $count = 1;
                  foreach ($latestDeposits as $latestDeposit) {
                    $class =  match($latestDeposit['status']) {
                      'FAILED' => 'badge-danger',
                      'SUCCESS' => 'badge-success',
                      default => 'badge-warning'
                    };

                    echo "<tr><td>".$count."</td><td>".$latestDeposit['amount']."</td>
                          <td><span class='badge ".$class." badge'>".$latestDeposit['status']."</span></td>
                          <td>".date('j M, Y h:i:s A',strtotime($latestDeposit['created_at']))."</td></tr>";

                    $count++;
                  }

                  if (empty($latestDeposits)) {
                    echo "<tr><td> No records found.. </td></tr>";
                  }

                  if (!empty($latestDeposits)) {
                      echo "<tr><th colspan='4' class='text-center'><a href='deposits.php?user_id=".$id."'> View All. </a></th></tr>";
                  }

                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">User details</h3>
              </div>
              <div class="card-body">
                <form action="info.php?id=<?php echo $id ?>" method="POST">
                <div class="row">
                  <div class="col-md-2">
                    <label for="name">
                    <span class="bold">
                      Full name
                    </span>
                    </label>
                  </div>
                  <div class="col-md-10">
                    <input id="name" class="form-control form-control-sm" type="text" name="name" value="<?php echo $user['name'] ?>">
                  </div>
                </div>
                <br>

                <div class="row">
                  <div class="col-md-2">
                    <label for="email">
                    <span class="bold">
                      Email
                    </span>
                    </label>
                  </div>
                  <div class="col-md-10">
                    <input id="email" class="form-control form-control-sm" type="text" name="email" value="<?php echo $user['email'] ?>">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-2">
                    <label for="phone">
                    <span class="bold">
                      Phone
                    </span>
                    </label>
                  </div>
                  <div class="col-md-10">
                    <input id="phone" class="form-control form-control-sm" type="text" name="phone" value="<?php echo $user['phone'] ?>">
                  </div>
                </div>

                <br>
                <div class="row">
                  <div class="col-md-2">
                    <label for="upi">
                    <span class="bold">
                      Payment
                    </span>
                    </label>
                  </div>
                  <div class="col-md-10">
                    <input id="upi" class="form-control form-control-sm" type="text" name="upi" value="<?php echo $user['upi'] ?>">
                  </div>
                </div>

                <br>
                <div class="row">
                  <div class="col-md-2">
                    <label for="status">
                    <span class="bold">
                      Status
                    </span>
                    </label>
                  </div>
                  <div class="col-md-10">
                    <div class="form-group">
                      <select name="status" id="status" class="form-control select2" style="width: 100%;">
                        <option <?php echo $isActive ? 'selected="selected"' : ''?> value = "1" >Active</option>
                        <option <?php echo !$isActive ? 'selected="selected"' : ''?> value = "0">InActive</option>
                      </select>
                    </div>
                  </div>
                </div>

                <br>
                <div class="row">
                  <button class="form-control btn btn-info" type="submit"> Submit </button>
                </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title"> Last 10 Orders </h3>
            </div>
              <div class="card-body p-0 overflow-auto">
                <table class="table table-striped table-hover">
                  <tbody>  <?php
                  $count = 1;
                  foreach ($executions as $order) {
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

                    echo "<tr><td>".$count."</td><td>".$order['game_id']."</td><td>".ucfirst($order['type'])."</td><td>".$order['selection']."</td><td>". $statusText ."</td>
                          <td><span class='badge badge-info'> ".$order['amount']." </span></td>
                          <td><span class='badge ".$result['class']." badge'> ".$result['text']." </span></td>
                          <td>".date('h:i:s A',strtotime($order['created_at']))."</td></tr>";

                    $count++;
                  }

                  if (!empty($executions)) {
                      echo "<tr><th colspan='8' class='text-center'><a href='orders.php?user_id=".$id."'> View All. </a></th></tr>";
                  }

                  if (empty($executions)) {
                    echo "<tr><td> No records found.. </td></tr>";
                  }

                  ?>
                  </tbody>
                    <tfoot>
                    <?php
//                    if (!empty($executions)) {
//                        echo "<div class='position-absolute' style='top:100%; left: 90%'><a href='orders.php?user_id=".$id."'><btn class='btn btn-secondary btn-sm btn-block'> View All. </btn></a></div>";
//                    }
                    ?>
                    </tfoot>
                </table>
              </div>
            <!-- /.card-body -->
            </div>
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title"> Last 10 referrals </h3>
              </div>
              <div class="card-body p-0 overflow-auto">
                <table class="table table-striped table-hover table-hover">
                  <tbody>  <?php
                  $count = 1;
                  foreach ($referredUsers as $referredUser) {
                    $class =  !$referredUser['active'] ? 'badge-danger' : 'badge-success';
                    $active = $referredUser['active'] ? 'Active' : 'InActive';
                    $contribution = (new \App\Models\Model('deposits'))->where('user_id', $referredUser['id'])->sum('amount');

                    echo "<tr><td>".$count."</td><td>".$referredUser['name']."</td><td>".$referredUser['email']."</td>    
                          <td><span class='badge ".$class." badge'> ".$active." </span></td><td>".$contribution."</td></tr>";

                    $count++;
                  }

                  if (empty($referredUser)) {
                    echo "<tr><td> No records found.. </td></tr>";
                  }

                  if (!empty($referredUser)) {
                      echo "<tr><th colspan='5' class='text-center'><a href='users.php?referred_by=".$id."'> View All. </a></th></tr>";
                  }

                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
        </div>
    </section>
  </div>

<?php
include('includes/footer.php');
?>


