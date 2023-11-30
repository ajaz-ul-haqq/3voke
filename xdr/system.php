<?php

require_once '../autoload.php';

include('includes/header.php');

$loggedInUser = $_SESSION['admin'];

$wrapperContext =  'Settings';

$breadCrumbs = ['home', 'settings'];
$activePages = ['System'];

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
                                <label for="keywords"> Keywords </label>
                                <input class="form-control" type="text" id="keywords" name="keywords"  value="<?php echo systemConfig('keywords')?>"><br>
                                <button type="button" id="saveKeyButton" class="btn btn-info form-control btn-sm"> Save </button>
                            </div>
                            <div class="col-md-4">
                                <label for="color"> Select Color </label>
                                <input class="form-control" type="color" id="color" name="color" value="<?php echo systemConfig('color')?>"><br>
                                <button type="button" id="saveColorButton" class="btn btn-info form-control btn-sm"> Save </button>
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
