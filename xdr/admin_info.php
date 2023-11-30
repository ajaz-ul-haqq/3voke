<?php

$wrapperContext = 'Admin Info';

$activePages = ['User Directory', 'All Admins'];

$breadCrumbs = ['home', 'admin', 'info'];

require_once '../autoload.php';
include('includes/header.php');

$loggedInUser = $_SESSION['admin'];

if (empty($_REQUEST['id'])) {
    header('Location:admins.php');
}

$id = $_REQUEST['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $admin = model('admins')->find($id);

    foreach ($admin as $item => $value) {
        if(isset($_POST[$item]) && ( $_POST[$item] != $value)){
            if ($item == 'password' && empty($_POST['password'])) {
                continue;
            }else{
                $valuesToUpdate[$item] = $_POST[$item];
            }
        }
    }

    if(!empty($valuesToUpdate['password'])){
        $valuesToUpdate['password'] = password_hash($valuesToUpdate['password'], PASSWORD_BCRYPT);
    }

    if(!empty($valuesToUpdate)) {
        model('admins')->where('id', $id)->update($valuesToUpdate);
        foreach ($valuesToUpdate as $key => $value) {
            ($key == 'password') ?: createLog('admin_updated', 'Updated Admin <b>'.$admin['phone'].'</b>, Set <b>'.$key.'</b> as <b>'.$value.'</b> from <b>'.$admin[$key].'</b>');
        }
    }
}

$admin = model('admins');
$admin = $admin->where('id', $id)->first();

$isActive = (bool) $admin['active'];

include ('includes/navbar.php');
include ('includes/sidebar.php');

$sessions = model('logs')->where('user_id', $id)
    ->orderBy('id')->select("DISTINCT(`session_id`)")->get();

?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>

    <section class="content">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">User details</h3>
                    </div>
                    <div class="card-body">
                        <form action="admin_info.php?id=<?php echo $id ?>" method="POST">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name">
                    <span class="bold">
                      Full name
                    </span>
                                    </label>
                                </div>
                                <div class="col-md-10">
                                    <input id="name" class="form-control form-control-sm" type="text" name="name" value="<?php echo $admin['name'] ?>">
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
                                    <input id="email" class="form-control form-control-sm" type="text" name="email" value="<?php echo $admin['email'] ?>">
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
                                    <input id="phone" class="form-control form-control-sm" type="text" name="phone" value="<?php echo $admin['phone'] ?>">
                                </div>
                            </div>

                            <?php

                            if(@$_SESSION['admin']['id'] == @$_REQUEST['id']) {
                                echo '<br>
                            <div class="row">
                                
                                <div class="col-md-2">
                                    <label for="password"><span class="bold">Password</span></label>
                                </div>
                                
                                  <div class="col-md-10">
                                    <input id="password" class="form-control form-control-sm" type="password" name="password" value="">
                                </div>
                            </div>';
                            }else {
                                echo '<br>
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
                                            <option '.(!$isActive ? 'selected="selected"' : '').' value = "1" >Active</option>
                                            <option '.(!$isActive ? 'selected="selected"' : '').' value = "0">InActive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>';
                            }
                            ?>

                            <br>
                            <div class="row">
                                <button class="form-control btn btn-dark" type="submit"> Submit </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title"> Logs </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <br>
                        <div class="timeline ml-3">

                            <?php
                            foreach ($sessions as $session) {

                                $timing = model('logs')->where('session_id', $session['session_id'])->value('created_at');

                                $logs = model('logs')->where('user_id', $id)
                                    ->where('session_id', $session['session_id'])->orderBy('id')->get();

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

                                echo '<div class="time-label">
                                <span class="bg-red"> Logged In '. date('j M, Y h:i A', strtotime($timing)).'</span>
                            </div>';
                            }
                            ?>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include('includes/footer.php')
?>
