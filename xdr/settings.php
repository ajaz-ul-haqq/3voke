<?php

require_once '../autoload.php';

include('includes/header.php');

$loggedInUser = $_SESSION['admin'];

$wrapperContext =  'System Settings';

$breadCrumbs = ['home', 'settings'];
$activePages = ['System', 'Settings'];

include('includes/navbar.php');
include('includes/sidebar.php');

?>

<div class="content-wrapper">
    <?php include('includes/wrapper.php'); ?>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h5>System Settings</h5>
                    </div>

                    <div class="card-body overflow-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="appTitle"> App Title </label>
                                <input class="form-control" type="text" id="appTitle" name="appTitle" value="<?php echo systemConfig('title')?>">
                                <br>
                                <button type="button" id="saveTitleButton" class="btn btn-info form-control btn-sm"> Save </button>
                            </div>
                            <div class="col-md-4">
                                <label for="keywords">Meta Keywords </label>
                                <input class="form-control" type="text" id="keywords" name="keywords"  value="<?php echo systemConfig('keywords')?>"><br>
                                <button type="button" id="saveKeyButton" class="btn btn-info form-control btn-sm"> Save </button>
                            </div>
                            <div class="col-md-4">
                                <label for="color"> App Theme </label>
                                <input class="form-control" type="color" id="color" name="color" value="<?php echo systemConfig('color')?>"><br>
                                <button type="button" id="saveColorButton" class="btn btn-info form-control btn-sm"> Save </button>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="m_w"> Minimum Withdrawl </label>
                                <input class="form-control" type="number" id="m_w" name="m_w" value="<?php echo systemConfig('minimum_withdrawl')?>">
                                <br>
                                <button type="button" id="saveMWButton" class="btn btn-info form-control btn-sm"> Save </button>
                            </div>
                            <div class="col-md-4">
                                <label for="m_r"> Minimum Deposit </label>
                                <input class="form-control" type="number" id="m_r" name="m_r"  value="<?php echo systemConfig('minimum_deposit')?>"><br>
                                <button type="button" id="saveMRButton" class="btn btn-info form-control btn-sm"> Save </button>
                            </div>
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
        const data = {};

        $('#saveColorButton').on('click', function (event) {
            const attr = 'color';
            const value = document.getElementById('color').value;
            const data = {
                attr : attr,
                value : value,
            }
            callApiNow(data);
        });

        $('#saveTitleButton').on('click', function (event) {
            const attr = 'title';
            const value = document.getElementById('appTitle').value;
            const data = {
                attr : attr,
                value : value,
            }
            callApiNow(data);
        });

        $('#saveMWButton').on('click', function (event) {
            callApiNow({
                attr : 'minimum_withdrawl',
                value : parseInt(document.getElementById('m_w').value),
            });
        });

        $('#saveMRButton').on('click', function (event) {
            callApiNow({
                attr : 'minimum_deposit',
                value : parseInt(document.getElementById('m_r').value),
            });
        });

        $('#saveKeyButton').on('click', function (event) {
            const attr = 'keywords';
            const value = document.getElementById('keywords').value;
            const data = {
                attr : attr,
                value : value,
            }
            callApiNow(data);
        });

        function callApiNow(data) {
            $.ajax({
                type: "POST",
                url: "actions.php?action=saveSettings",
                data: data,
                dataType: 'JSON',

                success: (res) => {
                    swal("Success!", res.message, "success").then(() => {
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
        }
    });
</script>
<!--#5b709a-->
