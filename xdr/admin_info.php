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
    $admin = model('admins');
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];

    $admin->where('id', $id)->update([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'active' => $status,
    ]);
}

$admin = model('admins');
$admin = $admin->where('id', $id)->first();

$isActive = (bool) $admin['active'];

include ('includes/navbar.php');
include ('includes/sidebar.php');
?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>

    <section class="content">
        <div class="row">
            <div class="col-md-7">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title"> Logs </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped table-hover">

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-dark">
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
                                <button class="form-control btn btn-dark" type="submit"> Submit </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include('includes/footer.php')
?>
