<?php

$wrapperContext = 'All Transactions';

$activePages = ['Merchants', 'Transactions'];

$breadCrumbs = ['home', 'merchants', 'transactions'];

require_once '../autoload.php';

include('includes/header.php');

include ('includes/navbar.php');
include ('includes/sidebar.php');

$transactions = model('transactions');

$limit = 10;
$page = 1;

$baseUrl = 'transactions.php?';

if (isset($_REQUEST['limit'])) {
    $limit = $_REQUEST['limit'];
}

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

if (isset($_REQUEST['merchant_id'])) {
    $transactions->where('merchant_id', $_REQUEST['merchant_id']);
    $baseUrl = $baseUrl.'merchant_id='.$_REQUEST['merchant_id'].'&';
}


$total = $transactions->count();

$prevPageUrl = $page > 1 ? $baseUrl.'limit='.$limit.'&page='.$page-1 : '';
$nextPageUrl = ($page * $limit)  >= $total ? '': $baseUrl.'limit='.$limit.'&page='.$page + 1;

$collections = $transactions->select('*')->offset($limit * ($page - 1) )->limit($limit)->get();

?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>


    <section class="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-body p-0 overflow-auto">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>User</th>
                                    <th>Merchant</th>
                                    <th>OrderId</th>
                                    <th>Amount</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 1;
                                foreach ($collections as $collection) {
                                    $user = model()->find($collection['user_id']);
                                    $merchant = model('merchant')->find($collection['merchant_id']);
                                    echo "<tr><td>".$count."</td><td>".clickAbleProfile($user)."</td>
                                    <td>".$merchant['name']."</td><td>".($collection['order_id'])."</td>
                                    <td>".$collection['amount']."</td><td>".date('h:i:s A',strtotime($collection['created_at']))."</td></tr>";

                                    $count++;
                                }

                                if (empty($collections)) {
                                    echo "<tr><td> No records found.. </td></tr>";
                                }

                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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

        $('#saveMerchant').on('click', function (event) {
            const merchantID = document.getElementById('mid').value;
            const upi = document.getElementById('upi').value;
            const token = document.getElementById('token').value;
            const secret = document.getElementById('secret').value;
            const mStatus = $('#mStatus').prop('checked');

            callApiNow({
                merchant_id : merchantID,
                upi : upi,
                token : token,
                secret : secret,
                mStatus :  ( mStatus ? 1 : 0 ),
            });
        });

        function callApiNow(data) {
            $.ajax({
                type: "POST",
                url: "actions.php?action=saveMerchant",
                data: data,
                dataType: 'JSON',

                success: (res) => {
                    swal("Success!", res.message, "success").then(() => {
                        window.location.reload();
                    });
                },

                error: (error) => {
                    console.log(error)
                    swal("Oops!", 'Something went wrong here', "error").then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    });
</script>

