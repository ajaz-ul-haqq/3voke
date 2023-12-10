<?php

$wrapperContext = 'All Vouchers';

$activePages = ['Payments', 'Vouchers'];

$breadCrumbs = ['home', 'payments'];

require_once '../autoload.php';

include('includes/header.php');

$limit = 10;
$page = 1;

if (isset($_REQUEST['limit'])) {
    $limit = $_REQUEST['limit'];
}

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}


$total = model('vouchers')->count();

$baseUrl = 'vouchers.php?';
$prevPageUrl = $page > 1 ? $baseUrl.'limit='.$limit.'&page='.$page-1 : '';
$nextPageUrl = ($page * $limit) >= $total ? '': $baseUrl.'limit='.$limit.'&page='.$page + 1;

$loggedInUser = $_SESSION['admin'];

$vouchers = model('vouchers')->select('*')->offset($limit * ($page - 1) )->limit($limit)->orderBy('id')->get();

include ('includes/navbar.php');
include ('includes/sidebar.php');

?>

    <div class="content-wrapper">
        <?php include ('includes/wrapper.php') ?>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Voucher</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="number" id="amount" class="form-control" placeholder="Enter voucher amount"></input>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="generateVoucher"> Generate </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <section class="content container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body  overflow-auto">
                            <div class="row mb-3">
                                <div class="col-md-10"></div>
                                <button type="button" class="btn btn-primary col-md-2" data-toggle="modal" data-target="#modal-default">
                                    Generate New
                                </button>
                            </div>
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Amount</th>
                                    <th>Details</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Redeemed By</th>
                                    <th>Updated At</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                foreach ($vouchers as $voucher) {
                                    $user = $voucher['used_by'] ? model()->where('id', $voucher['used_by'])->first() : [];

                                    $creator = $voucher['created_by'] > 0 ? model('admins')->find($voucher['created_by'])['phone'] : '3vokeBot' ;

                                    $profile = !empty($user) ? '<a href="info.php?id='.$user['id'].'">'.$user['phone'].'</a>' : '---';
                                    $active = $voucher['active'] ? '<button class="btn btn-sm btn-primary"> Active </button>' : '<button class="btn btn-sm btn-danger"> InActive </button>';

                                    echo "<tr><td>".$voucher['id']."</td><td>".$voucher['amount']."</td>
                          <td><span class='text-bold'>".$voucher['value']."</span></td>
                          <td><span class='text-danger'>".$creator."</span></td><td>".$active."</td>
                          <td><span class='text-bold'>".($profile)."</span></td>
                          <td>".date('j M, Y h:i:s A',strtotime($voucher['updated_at']))."</td></tr>";
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


<script>
    $().ready(function() {
        $('#generateVoucher').on('click', function (event){
            $.ajax({
                type: "POST",
                url: "actions.php?action=generateVoucher",
                data: { 'amount' : document.getElementById('amount').value },
                dataType: 'JSON',
                success: (res) => { window.location.reload(); },
                error: (error) => { console.log(error) }
            });
        });
    });
</script>


