<?php

require_once '../autoload.php';

include('includes/header.php');

$loggedInUser = $_SESSION['admin'];

$wrapperContext =  'System Logs';

$breadCrumbs = ['home', 'Logs'];
$activePages = ['System', 'Logs'];

include('includes/navbar.php');
include('includes/sidebar.php');

?>

<div class="content-wrapper">
    <?php include('includes/wrapper.php'); ?>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body  overflow-auto">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title"> All logs </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <br>
                                        <div class="timeline ml-3">

                                            <?php

                                            $logs = model('logs');

                                            if(isset($_REQUEST['user_id'])){
                                                $logs = $logs->where('user_id', $_REQUEST['user_id']);
                                            }

                                            $logs = $logs->orderBy('id')->get();

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

                                        <br>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php
include('includes/footer.php');
?>
<!--#5b709a-->
