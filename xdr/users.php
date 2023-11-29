<?php

require_once '../autoload.php';

include('includes/header.php');

$loggedInUser = $_SESSION['admin'];

$wrapperContext =  'All Users';

$breadCrumbs = ['home', 'users', 'list'];

$users = model();
$baseUrl = 'users.php?';

if(isset($_REQUEST['search'])) {
  $searchString = $_REQUEST['search'];
  $users->where('name', 'LIKE', '%'.$searchString.'%')
    ->orWhere('email', 'LIKE','%'.$searchString.'%')
    ->orWhere('phone', 'LIKE', '%'.$searchString.'%');
   $baseUrl = $baseUrl. 'search='.($searchString ?? '').'&';
}

$limit = 10;
$page = 1;

if (isset($_REQUEST['limit'])) {
  $limit = $_REQUEST['limit'];
}

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

if (isset($_REQUEST['referred_by'])) {
    $users->where('referred_by', $_REQUEST['referred_by']);
    $baseUrl = $baseUrl.'referred_by='.$_REQUEST['referred_by'].'&';
}

if (isset($_REQUEST['registered_today']) && $_REQUEST['registered_today']) {
    $users->where('created_at', '>', (date('Y-m-d').':00:00:00'));
    $baseUrl = $baseUrl.'registered_today=true&';
}


$total = $users->count();

$prevPageUrl = $page > 1 ? $baseUrl.'limit='.$limit.'&page='.$page-1 : '';
$nextPageUrl = ($page * $limit)  >= $total ? '': $baseUrl.'limit='.$limit.'&page='.$page + 1;

$users = $users->select('*')->offset($limit * ($page - 1) )->limit($limit)->get();

$activePages = ['User Directory', 'All Users'];

include('includes/navbar.php');
include('includes/sidebar.php');

?>

<div class="content-wrapper">
    <?php include('includes/wrapper.php'); ?>
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body overflow-auto">
              <form action="users.php" method="get">
                <div class="row">
                  <input class="form-control ml-5 col-md-8" name="search" type="text" value="<?php echo $searchString ?? '' ?>" placeholder='Search here'">
                  <button type="submit" class="form-control ml-5 btn btn-light btn-outline-dark col-md-2"> Search </button>
                </div>
              </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body  overflow-auto">
              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Balance</th>
                  <th>Active</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($users as $user) {
                    $href = "info.php?id=".$user['id'];
                  $active = $user['active'] ? '<button class="btn btn-sm btn-primary"> Yes </button>' : '<button class="btn btn-sm btn-danger"> NO </button>';
                  $editAction = "<span><a href='".$href."'><button class='btn btn-sm btn-light btn-outline-dark'>  Info </button></a></span>";
                  echo "<tr>
                             <td>".$user['name']."</td>
                             <td>".$user['email']."</td>
                             <td>".clickAbleProfile($user)."</td>
                             <td>".$user['balance']."</td>
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
include('includes/footer.php')
?>
