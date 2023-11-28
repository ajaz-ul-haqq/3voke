<?php

$wrapperContext =  'Winning Managements';

$activePages = ['Manage', 'Winnings'];

$breadCrumbs = ['home', 'manage', 'wins'];

require_once '../autoload.php';

include('includes/header.php');

$category = 'parity';

if(isset($_REQUEST['category'])){
    $category = $_REQUEST['category'];
}

$nums = range(0,9);

include('includes/navbar.php');
include('includes/sidebar.php');

echo '<input type="hidden" name="category" id="category" value="'.$category.'">';

?>

<div class="content-wrapper">
    <?php include ('includes/wrapper.php') ?>

    <div class="card-body overflow-auto row">
        <div class="col-md-3">
            <h5><b>GameID</b> : <span id="gameId"><?php echo currentGameId(); ?> </span> </h5>
        </div>
        <div class="col-md-2">
            <h5><b> Time </b> : <span id="timer"> </span> </h5>
        </div>
        <div class="col-md-2">
            <h5><b> Suggestion </b> : <span id="suggestion"> </span> </h5>
        </div>
        <div class="col-md-4">
            <span><b>Category </b> : </span>
                <?php
                foreach (['parity', 'sapre', 'bcone', 'emerd'] as $type)
                {
                    echo '
                      <input type="radio" name="categorySelect" id="switch_'.$type.'" value="'.$type.'">
                      <label for="switch_'.$type.'">'.$type.'</label>
                    &nbsp';
                }
                ?>
        </div>
    </div>

    <div class="card-body  overflow-auto">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Number</th>
                    <th>Returns</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                <?php
                 foreach ($nums as $num) {
                     echo '<tr>
                    <td>'.$num.'</td>
                    <td id="'.$category.'_'.$num.'"> --- </td>
                    <td><div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="'.$category.'_switch_'.$num.'">
                      <label class="custom-control-label" for="'.$category.'_switch_'.$num.'"></label>
                    </div>
                  </div></td>
                </tr>';
                 }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include('includes/footer.php')
?>


<script>

    $().ready(function() {
        document.getElementById('switch_'+document.getElementById('category').value).checked = true;

        getROIData();

        setInterval(function() {
            timerData();
        }, 1e3);

        setInterval(function() {
            getROIData();
        }, 3000);

        function timerData() {
            $(".showload").hide();
            $(".none").show();
            var countDownDate = Date.parse(new Date) / 1e3;
            var now = new Date().getTime();
            var distance = 180 - countDownDate % 180;
            var i = distance / 60,
                n = distance % 60,
                o = n / 10,
                s = n % 10;
            var minutes = Math.floor(i);
            var seconds = ('0'+Math.floor(n)).slice(-2);

            if (distance === 1 || distance === 180) {
                getROIData()
            }

            document.getElementById('timer').innerHTML = "<span class='timer'>0"+Math.floor(minutes)+"</span>" + "<span>:</span>" +"<span class='timer'>"+seconds+"</span>";
        }

        function getROIData()
        {
            $.ajax({
                type: "GET",
                url: "actions.php?action=getROIs",
                data: {
                    'category' : document.getElementById('category').value
                },

                success :(res) => {
                    const category = document.getElementById('category').value
                    res.data.data.forEach((item) => {
                        const key = item.number;
                        document.getElementById(category+'_'+key).innerHTML = item.returns;
                        document.getElementById(category+'_switch_'+key).checked = item.active;
                    })
                    document.getElementById('gameId').innerHTML = res.data.gameId;
                    document.getElementById('suggestion').innerHTML = res.data.suggestion;
                },

                error :(error) =>  {
                    console.log(error)
                    alert('Error in console')
                }
            });
        }

        $('input[type="checkbox"]').on('click', function (event){
            let id = (event.target.id);
            let number = id.split('_');
            number = number[2];

            $.ajax({
                type: "POST",
                url: "actions.php?action=customizeNumber",
                dataType : 'JSON',
                data: {
                    'number' : number,
                    'category' : document.getElementById('category').value
                },

                success :() => {},

                error :(error) =>  {
                    console.log(error)
                    alert('Error in console')
                }
            });
        });

        $('input[type="radio"]').on('click', function (event){
            const category = (event.target.value);
            document.getElementById('category').value = category;
            document.getElementById('switch_'+category).checked = true;
            window.location.href = 'wins.php?category='+category;
        });
    });
</script>
