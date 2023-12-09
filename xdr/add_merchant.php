<?php

$wrapperContext = 'Add Merchant';

$activePages = ['Merchants', 'add_merchant'];

$breadCrumbs = ['home', 'merchants', 'Create'];

require_once '../autoload.php';

include('includes/header.php');

include ('includes/navbar.php');
include ('includes/sidebar.php');
?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>


    <section class="content">
        <div class="container mt-3">
            <div class="row">
                <div class="card card-dark" style="min-width: 100%">
                    <div class="card-header">
                        <h3 class="card-title">Merchant details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="mName">
                                    <span class="bold"> Merchant Name </span>
                                </label>
                            </div>
                            <div class="col-md-10">
                                <input id="mName" class="form-control form-control-sm" type="text" name="mName" value="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="mid">
                                    <span class="bold"> Merchant ID </span>
                                </label>
                            </div>
                            <div class="col-md-10">
                                <input id="mid" class="form-control form-control-sm" type="text" name="mid" value="">
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
                                <input id="upi" class="form-control form-control-sm" type="text" name="upi" value="">
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
                                <input id="token" class="form-control form-control-sm" type="text" name="token" value="">
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
                                <input id="secret" class="form-control form-control-sm" type="text" name="secret" value="">
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
                                        <input type="checkbox" class="custom-control-input" id="mStatus" >
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
                name : document.getElementById('mName').value,
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
                    swal("Oops!", 'Something went wrong here', "error");
                }
            });
        }
    });
</script>

