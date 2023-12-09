<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> <?php echo $wrapperContext ?> </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php
                    foreach ($breadCrumbs as $key => $value) {
                        $isLastItem = $key === count($breadCrumbs) - 1;
                        echo '<li class="breadcrumb-item '.($isLastItem ? 'active' : '').'">'.getHrefForBreadCrumbs($value, $isLastItem).'</li>';
                    }
                    ?>
<!--                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>-->
<!--                    <li class="breadcrumb-item active"> Users </li>-->
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<?php

function getHrefForBreadCrumbs($key, $isLast): string
{
    if ($isLast) {
       return ucfirst($key);
    }
    return match ($key) {
        'home' => '<a href="index.php">Home</a>',
        'manage' => 'Manage',
        'users' => '<a href="users.php">Users</a>',
        'payments' => 'Payments',
        'withdrawals' => '<a href="withdrawls.php">Withdrawals</a>',
        'merchants' => '<a href="merchants.php">Merchants</a>',
        'admin' => '<a href="admins.php">Admin</a>',
        'add_merchant' => '<a href="add_merchant.php">Create</a>',
        default => ucfirst($key)
    };
}

?>