<?php

$wrapperContext = 'Withdrawal Info';

$activePages = ['Payments', 'Withdrawals'];

$breadCrumbs = ['home', 'withdrawals', 'info'];

require_once '../autoload.php';

require_once '../helpers.php';

include('includes/header.php');

if( ! isset($_SESSION['admin'])) {
    header('Location:login.php');
}

$info = model('withdrawls')->find(@$_REQUEST['id']);

$context = $info['status'] != 'APPROVED' ? '<button class="btn btn-lg btn-success btn-block" id="approve_btn">APPROVE</button>
                        <button class="btn btn-lg btn-danger btn-block" id="decline_btn">REJECT</button>' : '<button class="btn btn-lg btn-info btn-block" id="complete_btn">MARK AS COMPLETED</button>';

$user = model()->find($info['user_id']);

$latestWithdrawls = model('withdrawls')->where('user_id', $info['user_id'])
    ->where('id', '!=', @$_REQUEST['id'])->orderBy('id')->take(10);

include ('includes/navbar.php');
include ('includes/sidebar.php');

echo '<input type="hidden" id="withdrawlId" value="'.@$_REQUEST['id'].'">';
?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Withdrawal Info
                    </div>
                    <div class="card-body  overflow-auto">
                        <table class="table table-bordered table-striped table-hover">
                            <tbody>

                            <tr>
                                <th>STATUS</th>
                                <td><?php
                                    $class =  match($info['status']) {
                                        'APPROVED' => 'badge-primary',
                                        'REJECTED' => 'badge-danger',
                                        'COMPLETED' => 'badge-success',
                                        default => 'badge-warning'
                                    };
                                    echo "<span class='badge ".$class." badge'>".$info['status']."</span>"
                                    ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>
                                    <?php
                                       echo $user['name']
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td>
                                    <?php
                                    echo $user['phone']
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Amount</th>
                                <td><?php echo $info['amount'] ?></td>
                            </tr>

                            <tr>
                                <th>UPI</th>
                                <td><?php echo $user['upi'] ?></td>
                            </tr>

                            <tr>
                                <th>Requested At</th>
                                <td><?php echo date('j M, Y h:i:s A',strtotime($info['created_at'])) ?></>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php echo in_array($info['status'],['COMPLETED', 'REJECTED']) ? '' :'<div class="card"><div class="card-body">'.$context.' </div></div>'; ?>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Last 10 withdrawal by same user
                    </div>
                    <div class="card-body  overflow-auto">
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
                          <td>".date('j M, Y h:i:s A',strtotime($latestWithdrawl['created_at']))."</td>
                          
                          <td><a href='withdrawl-info.php?id=".$latestWithdrawl['id']."'><button class='btn btn-sm btn-light btn-outline-dark'> View </button></a></td></tr>";

                                $count++;
                            }

                            if (empty($latestWithdrawls)) {
                                echo "<tr><td> No records found.. </td></tr>";
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include('includes/footer.php');
?>

<script>
    $().ready(function() {
        $('#approve_btn').on('click', function (event){
            $.ajax({
                type: "GET",
                url: "actions.php?action=approveWithdrawal",
                data: {
                    'withdrawlId': document.getElementById('withdrawlId').value
                },
                dataType: 'JSON',

                success: (res) => {
                    swal("Success!", 'Withdrawal Approved Successfully', "success").then(() => {
                        window.location.reload();
                    });
                },

                error: (error) => {
                    console.log(error)
                    swal("Oops!", 'Something went wrong here', "success").then(() => {
                        window.location.reload();
                    });
                }
            });
        });


        $('#decline_btn').on('click', function (event){
            $.ajax({
                type: "GET",
                url: "actions.php?action=declineWithdrawal",
                data: {
                    'withdrawlId': document.getElementById('withdrawlId').value
                },
                dataType: 'JSON',

                success: (res) => {
                    swal("Success!", 'Withdrawal Rejected Successfully', "error").then(() => {
                        window.location.reload();
                    });
                },

                error: (error) => {
                    console.log(error)
                    swal("Oops!", 'Something went wrong here', "success").then(() => {
                        window.location.reload();
                    });
                }
            });
        });

        $('#complete_btn').on('click', function (event){
            $.ajax({
                type: "GET",
                url: "actions.php?action=completeWithdrawal",
                data: {
                    'withdrawlId': document.getElementById('withdrawlId').value
                },
                dataType: 'JSON',

                success: (res) => {
                    swal("Success!", 'Withdrawal Completed Successfully', "success").then(() => {
                        window.location.reload();
                    });
                },

                error: (error) => {
                    console.log(error)
                    swal("Oops!", 'Something went wrong here', "success").then(() => {
                        window.location.reload();
                    });
                }
            });
        });
    });
</script>

