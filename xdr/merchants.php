<?php

$wrapperContext = 'Merchants List';

$activePages = ['Merchants', 'List'];

$breadCrumbs = ['home', 'merchants'];

require_once '../autoload.php';

include('includes/header.php');

include ('includes/navbar.php');
include ('includes/sidebar.php');

$merchants = model('merchant');

$limit = 10;
$page = 1;

if (isset($_REQUEST['limit'])) {
    $limit = $_REQUEST['limit'];
}

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$total = $merchants->count();
$baseUrl = 'merchants.php?';
$prevPageUrl = $page > 1 ? $baseUrl.'limit='.$limit.'&page='.$page-1 : '';
$nextPageUrl = ($page * $limit)  >= $total ? '': $baseUrl.'limit='.$limit.'&page='.$page + 1;

$merchants = $merchants->select('*')->offset($limit * ($page - 1) )->limit($limit)->get();


?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>


    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body overflow-auto">
                        <div class="row">
                            <div class="col-md-7">

                            </div>
                            <div class="col-md-5">
                                <a href="add_merchant.php"> <button type="button" class="btn btn-primary col-md-2" data-toggle="modal" data-target="#modal-default">
                                        Add New </button> </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body  overflow-auto">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>UPI</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($merchants as $merchant) {
                                $href = "merchant_info.php?id=".$merchant['id'];
                                $active = $merchant['status'] ? '<button class="btn btn-sm btn-primary"> Yes </button>' : '<button class="btn btn-sm btn-danger"> NO </button>';
                                $editAction = "<span><a href='".$href."'><button class='btn btn-sm btn-light btn-outline-dark'>  View </button></a></span>";
                                echo "<tr>
                             <td>".$merchant['name']."</td>
                             <td>".$merchant['upi']."</td>
                             <td> ".$active."</td>
                             <td>".$editAction." </td>
                          </tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-10 pl-4">
                            <?php echo $limit * ($page - 1) + 1 . ' to '. min($total, $limit * $page) . ' out of '.$total.' records' ?>
                        </div>
                        <div class="col-md-2">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php echo !empty($prevPageUrl) ? 'disabled' : '' ?>disabled">
                                        <a class="page-link" href="<?php echo $prevPageUrl ?>" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item <?php echo !empty($nextPageUrl) ? 'disabled' : '' ?>disabled ">
                                        <a class="page-link" href="<?php echo $nextPageUrl ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
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