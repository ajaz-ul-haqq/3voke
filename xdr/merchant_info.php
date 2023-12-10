<?php

$wrapperContext = 'Merchant Configuration';

$activePages = ['Merchants', 'List'];

$breadCrumbs = ['home', 'merchants', 'Info'];

require_once '../autoload.php';

include('includes/header.php');

include ('includes/navbar.php');
include ('includes/sidebar.php');

if( ! isset($_REQUEST['id'])) {
    header('Location:merchants.php');
}

$merchant = model('merchant')->where('id',$_REQUEST['id'])->first();

if (empty($merchant)) {
    header('Location:merchants.php');
}

$status = $merchant['status'];


$collections = model('transactions')->where('merchant_id', $merchant['id'])->orderBy('id')->take(10);

?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>


    <section class="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-dark" style="min-width: 100%">
                        <div class="card-header">
                            <h3 class="card-title">Merchant details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="mid">
                                        <span class="bold"> Merchant ID </span>
                                    </label>
                                </div>
                                <div class="col-md-10">
                                    <input id="mid" class="form-control form-control-sm" type="text" name="mid" value="<?php echo $merchant['merchant_id'] ?>" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="upi">
                                        <span class="bold"> Merchant UPI </span>
                                    </label>
                                </div>
                                <div class="col-md-10">
                                    <input id="upi" class="form-control form-control-sm" type="text" name="upi" value="<?php echo $merchant['upi'] ?>">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="token">
                                        <span class="bold"> Token </span>
                                    </label>
                                </div>
                                <div class="col-md-10">
                                    <input id="token" class="form-control form-control-sm" type="text" name="token" value="<?php echo $merchant['token'] ?>">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="token">
                                        <span class="bold"> Secret </span>
                                    </label>
                                </div>
                                <div class="col-md-10">
                                    <input id="secret" class="form-control form-control-sm" type="text" name="secret" value="<?php echo $merchant['secret'] ?>">
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="mStatus">
                                        <span class="bold"> Status </span>
                                    </label>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="mStatus" <?php echo  ($status ? 'checked' : '')?> >
                                            <label class="custom-control-label" for="mStatus"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <button class="form-control btn btn-primary" type="button" id="saveMerchant"> Submit </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title"> Last 10 Payments </h3>
                        </div>
                        <div class="card-body p-0 overflow-auto">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>User</th>
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
                                    echo "<tr><td>".$count."</td><td>".clickAbleProfile($user)."</td><td>".($collection['order_id'])."</td>
                                    <td>".$collection['amount']."</td><td>".date('h:i:s A',strtotime($collection['created_at']))."</td></tr>";

                                    $count++;
                                }

                                if (!empty($collections)) {
                                    echo "<tr><th colspan='5' class='text-center'><a href='transactions.php?merchant_id=".$merchant['id']."'> View All. </a></th></tr>";
                                }

                                if (empty($collections)) {
                                    echo "<tr><th colspan='5' style='text-align: center'> No records found.. </th></tr>";
                                }

                                ?>
                                </tbody>
                                <tfoot>
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
                    console.log(error);
                    alert(error.responseText);
                    swal("Oops!", 'Something went wrong here', "error").then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    });
</script>

