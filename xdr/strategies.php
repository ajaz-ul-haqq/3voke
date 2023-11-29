<?php

require_once '../autoload.php';

include('includes/header.php');

$wrapperContext =  'Strategies';

$breadCrumbs = ['home', 'manage', 'strategies'];

$activePages = ['Manage', 'Strategies'];

$strategies = model('strategies')->get();

include('includes/navbar.php');
include('includes/sidebar.php');

?>

<div class="content-wrapper">
    <?php include('includes/wrapper.php'); ?>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body  overflow-auto">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($strategies as $strategy) {
                                $active = $strategy['active'] ? '<button class="btn btn-sm btn-primary"> Active </button>' : '<button class="btn btn-sm btn-danger"> InActive </button>';
                                $editAction = "<button class='btn btn-sm btn-light btn-outline-dark' id='strategy_".$strategy['id']."'> ". ($strategy['active'] ? 'Disable' : 'Enable')." </button>";
                                echo "<tr>
                             <td>".$strategy['id']."</td>
                             <td>".$strategy['name']."</td>
                             <td>".$strategy['description']."</td>
                             <td>".$active."</td>
                             <td>".$editAction."</td>
                          </tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include('includes/footer.php')
?>

<script>
    $('button').on('click', function (event){
        const stax = ((event.target.id).split('_'))[1];
        $.ajax({
            type: "POST",
            url: "actions.php?action=customizeStrategy",
            dataType : 'JSON',
            data: {
                's_id' : stax,
            },

            success :() => {
                window.location.reload();
            },

            error :(err) =>  {
                window.location.reload();
            }
        });
    });
</script>
