<?php

require_once 'autoload.php';

session_start();
if (!isset($_SESSION['user'])) {
    redirectTo('login.php');
}

$userid = $_SESSION['user']['id'];

?>
<!doctype html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
    <style>
        circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px; /* Adjust spacing between circles */
        }

        .red-bg {
            background-color: red;
        }

        .violet-bg {
            background-color: darkviolet;
        }

        .btn {
            border-radius: 10px 10px 10px 10px;
            border: 2px solid white;

            transition: 0.5s;

        }

        .appHeader1 {
            background-color: #fff !important;
            border-color: #fff !important;
        }
        .appContent3 {
            background-color: #2196f3 !important;
            border-color: #2196f3 !important;
            padding:10px;
            border-radius:3px;
            font-size:16px;
        }
        .user-block img {
            width: 40px;
            height: 40px;
            float: left;
            margin-right:10px;
            background:#333;
        }
        .img-circle {
            border-radius: 50%;
        }
        .reaload {
            box-shadow:none;
        }
        .ion-md-refresh {
            font-size:30px !important;
        }
        .responsive {
            height:300px;
            overflow-x: auto;
        }
        .vcard {
            box-shadow:none;
        }
        h5{ color:#888; font-size:20px; font-weight:normal;}
        h5 span{ color:#333; font-size:20px;}
        .divsize4 .btn{padding: 0 10px; width:80px;}
        .left-addon input {
            padding-left: 20px;
        }
        .error {
            top: 45px;
        }
        .containerrecord{border-bottom: solid 2px #565EFF;}
        .recordlink{
            font-size: 30px;
            color: #333;
            border-bottom: solid 2px #565EFF ;
        }
        .recordlink .title{font-size: 14px;
            font-weight: 500;}
        #alert h4{font-size: 1rem;}
        #alert p{font-size: 13px; margin-top:30px;}
        #alert .modal-content{border-radius:3px}
        #alert .modal-dialog{padding:30px; margin-top:200px;}
        #payment .modal-dialog{padding:10px;margin-top:60px;}
        #loader .modal-dialog{padding:30px; margin-top:200px;}

        .btn-lg {
            height: 42px;
            padding: 0px 24px;
            font-size: 15px;
        }
        .vg{
            background: linear-gradient(137.11deg, #7400AB -9.13%, #7400AB 49.79%, #1DCC70 49.8%, #1DCC70 107.5%) !important;
        }
        .rv{
            background: linear-gradient(137.11deg, #7400AB -9.13%, #7400AB 49.79%, #ff2d55 49.8%, #ff2d55 107.5%) !important;
        }
        .btn-blue{
            background-color:#2196f3;
        }
        .btn {
            border-radius: 3px 3px 3px 3px;
            border: 0px solid white;
            transition: 0.5s;
            color:#d9d5db;
        }
        .btn-blue{
            background-color:#2196f3;
            color:#d9d5db;
        }

        .hidden-details {
            display: none;
            background-color: #f2f2f2;
        }

        .data-row:hover + .hidden-details {
            display: table-row;
        }

        .point {
            display: inline-block; /* Display divs side by side */
        }

    </style>
</head>

<body class="pb-5">
<!-- Page loading -->

<div id="spinner-div" class="pt-5">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>

<div id="responseHandler" class="pt-5">
    <span id="responseMessage" class="badge responseBadge badge-danger"> </span>
</div>


<!-- App Header -->
<div class="vcard" >
    <div class="appContent3 text-white" style="background-color:lightslategrey !important">
        <div class="row">
            <div class="col-12">
                <div class="col-12 mb-1" style="font-size:18px;">Available balance: ₹ <span id="balance"></span></div>
                <div class="col-12">
                    <div>
                        <a href="recharge.php" class="btn btn-sm btn-primary m-0">Recharge</a>
                        <a href="withdrawl.php" class="btn btn-sm  btn-info btn-default ml-1 m-0">Withdraw</a>

                        <a href="javascript:void(0);" onClick="getResultbyCategory(
                            document.getElementById('activeCategory').value, document.getElementById('activeCategory').value)"
                           class="reaload text-white pull-right mt-1" onclick="">
                            <i class="icon ion-md-refresh"></i></a> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- searchBox -->

<!-- * searchBox -->
<!-- * App Header -->

<!-- App Capsule -->
<div class="mb-5 col-md-12">
    <div class="long mb-3">
        <!-- listview -->
        <ul class="nav nav-tabs size4" id="myTab3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#parity" role="tab" onClick="getResultbyCategory('parity','parity'); getUserOrder(1, 'parity')">Parity</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#sapre" role="tab" onClick="getResultbyCategory('sapre','sapre'); getUserOrder(1, 'sapre')">Sapre</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#bcone" role="tab" onClick="getResultbyCategory('bcone','bcone'); getUserOrder(1, 'bcone')">Bcone</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#emerd" role="tab" onClick="getResultbyCategory('emerd','emerd'); getUserOrder(1, 'emerd')">Emerd</a>
            </li>
        </ul>

        <!--=====================game area============================-->
        <div class="appContent1 bg-light mt-n1">
            <div class="layout">
                <div class="gameidtimer">
                    <h5 class="mb-2"><i class="icon ion-md-trophy"></i> Period</h5>
                    <h5>
                        <span class="showload">
                            <div class="spinnner-border text-danger" role="status"></div></span>
                        <span id="gameid" class="none"></span>
                        <input type="hidden" id="futureid" name="futureid" value="123">
                    </h5>
                </div>
                <div class="gameidtimer text-right">
                    <h5 class="mb-2">Count Down</h5>
                    <h5 id="demo"></h5>
                </div>
            </div>

            <input type="hidden" id="activeCategory" value="parity"></input>
            <input type="hidden" id="activePage" value="parity"></input>

            <div class="bg-light layout text-center">
                <div class="divsize4">
                    <button type="button" class="btn btn-sm btn-success gbutton none" onClick="betbutton('#1DCC70','button','green');">Green</button>
                </div>
                <div class="divsize4">
                    <button type="button" class="btn btn-sm btn-violet gbutton none" onClick="betbutton('#9c27b0','button','violet');">Violet</button>
                </div>
                <div class="divsize4">
                    <button type="button" class="btn btn-sm btn-danger gbutton none" onClick="betbutton('#ff2d55','button','red');">Red</button>
                </div>
            </div>


            <div class="container-fluid  ">
                <div class="row layout text-center bg-light d-flex justify-content-center">

                    <div class="divsize2">
                        <button type="button" class="btn btn-sm gbutton none btn-danger rv" onClick="betbutton('#ff2d55','button','0');">0</button>
                    </div>
                    <div class="divsize2">
                        <button type="numbutton" class="btn btn-sm btn-success gbutton none" onClick="betbutton('#1DCC70','button','1');">1</button>
                    </div>

                    <div class="divsize2">
                        <button type="button" class="btn btn-sm btn-danger gbutton none" onClick="betbutton('#ff2d55','button','2');">2</button>
                    </div>

                    <div class="divsize2">
                        <button type="button" class="btn btn-sm btn-success gbutton none" onClick="betbutton('#1DCC70','button','3');">3</button>
                    </div>

                    <div class="divsize2">
                        <button type="button" class="btn btn-sm btn-danger gbutton none" onClick="betbutton('#ff2d55','button','4');">4</button>
                    </div>

                </div>
                <div class="row layout text-center bg-light d-flex justify-content-center">

                    <div class="divsize2">
                        <button type="button" class="btn btn-sm btn-success gbutton none vg " onClick="betbutton('#1DCC70','button','5');">5 </button>
                    </div>

                    <div class="divsize2">
                        <button type="button" class="btn btn-sm btn-danger gbutton none" onClick="betbutton('#ff2d55','button','6');"> 6</button>
                    </div>

                    <div class="divsize2">
                        <button type="button" class="btn btn-sm btn-success gbutton none" onClick="betbutton('#1DCC70','button','7');">7 </button>
                    </div>
                    <div class="divsize2">
                        <button type="button" class="btn btn-sm btn-danger gbutton none" onClick="betbutton('#ff2d55','button','8');"> 8</button>
                    </div>
                    <div class="divsize2">
                        <button type="button" class="btn btn-sm btn-success gbutton none" onClick="betbutton('#1DCC70','button','9');">9 </button>
                    </div>
                </div>
            </div>
        </div>
        <!--=====================game area end============================-->

        <div class="mt-1">
            <div class="tab-content" id="myTabContent">
                <!--=========================tab-1========================================-->
                <div class="tab-pane fade active show" id="parity" role="tabpanel"></div>
                <!--=========================tab-1 end========================================-->
                <!--=========================tab-2========================================-->
                <div class="tab-pane fade" id="sapre" role="tabpanel"></div>
                <!--=========================tab-2 end========================================-->
                <!--=========================tab-3========================================-->
                <div class="tab-pane fade" id="bcone" role="tabpanel"></div>
                <!--=========================tab-3 end========================================-->
                <!--=========================tab-4========================================-->
                <div class="tab-pane fade" id="emerd" role="tabpanel"></div>
                <!--=========================tab-4 end========================================-->
            </div>
        </div>
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item" id="previousButton" style="display: block">
                <a class="page-link" href="javascript:void(0);" onclick="getResultbyCategory(
                                    document.getElementById('activeCategory').value, document.getElementById('activeCategory').value,
                                    ( parseInt(document.getElementById('activePage').value, 10 ) - 1 ), 10
                             )">&laquo;</a>
            </li>
            <li class="page-item" id="nextButton" style="display: block">
                <a class="page-link" href="javascript:void(0);" onclick="getResultbyCategory(
                                    document.getElementById('activeCategory').value, document.getElementById('activeCategory').value,
                                    ( parseInt(document.getElementById('activePage').value, 10 ) + 1 ), 10
                             )">&raquo;</a>
            </li>
        </ul>

        <div class="tab-content pt-2" id="myOrders">
            <h5 style="text-align: center"class="mt-4"> <b>My Orders</b></h5>
            <!--=========================tab-1========================================-->
            <div class="tab-pane fade active show" id="myOrdersDataTable"   ></div>
            <!--=========================tab-1 end========================================-->
        </div>


        <input type="hidden" id="activePageForRecords" name="activePageForRecords" value="1"/>

        <div class="row">
            <div class="col-sm-5">
                <nav aria-label="recordsTablePagination">
                    <ul class=" pagination pagination-sm m-0 float-right">
                        <li class="page-item" id="recordsPreviousButton" style="display: none">
                            <a class="page-link" href="javascript:void(0);" onclick="getUserOrder(
                                parseInt(document.getElementById('activePageForRecords').value) - 1,
                                document.getElementById('activeCategory').value
                                )">&laquo;</a>
                        </li>
                        <li class="page-item" id="recordsNextButton" style="display: block">
                            <a class="page-link" href="javascript:void(0);" onclick="getUserOrder(
                                parseInt(document.getElementById('activePageForRecords').value) + 1,
                                document.getElementById('activeCategory').value
                            )">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        </div>
    </div>
</div>
<!-- appCapsule -->
<?php include("footer.php");?>
<div id="rule" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header"> </div>
            <div class="modal-body responsive"> wsedrfyguhij </div>
            <div class="modal-footer">
                <a type="button" class="pull-left" data-dismiss="modal"><strong>CLOSE</strong></a>
            </div>
        </div>
    </div>
</div>

<div id="payment" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header paymentheader" id="paymenttitle">
                <h4 class="modal-title" id="chn"></h4>
            </div>
            <form action="#" method="post" id="bettingForm" autocomplete="off">
                <div class="modal-body mt-1" id="loadform">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-1">Contract Money</p>
                            <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                <label class="btn btn-secondary active" onClick="contract(10);">
                                    <input class="contract" type="radio" name="contract" id="hoursofoperation" value="10" checked >
                                    10 </label>
                                <label class="btn btn-secondary" onClick="contract(100);">
                                    <input type="radio" class="contract" name="contract" id="hoursofoperation" value="100">
                                    100 </label>
                                <label class="btn btn-secondary" onClick="contract(1000);">
                                    <input type="radio" class="contract" name="contract" id="hoursofoperation" value="1000">
                                    1000 </label>
                                <label class="btn btn-secondary" onClick="contract(10000);">
                                    <input type="radio" class="contract" name="contract" id="hoursofoperation" value="10000" >
                                    10000 </label>
                            </div>

                            <input type="hidden" id="contractmoney" name="contractmoney" value="10">

                            <p class="mb-1">Contract Count</p>
                            <div class="def-number-input number-input safari_only">
                                <button type="button" onClick="this.parentNode.querySelector('input[type=number]').stepDown(); addvalue();" class="minus"></button>
                                <input class="quantity" min="1" name="amount" id="amount" value="1" type="number" onKeyUp="addvalue();">
                                <button type="button" onClick="this.parentNode.querySelector('input[type=number]').stepUp(); addvalue();" class="plus"></button>
                            </div>
                            <input type="hidden" name="userid" id="userid" class="form-control" value="<?php echo $userid;?>">
                            <input type="hidden" name="type" id="type" class="form-control">
                            <input type="hidden" name="value" id="value" class="form-control" >
                            <input type="hidden" name="counter" id="counter" class="form-control" >
                            <input type="hidden" name="inputgameid" id="inputgameid" class="form-control" value="hiddenKiMaaKi">
                            <div class="mt-2">Total contract money is <span id="showamount">10</span></div>
                            <input type="hidden" name="finalamount" id="finalamount" value="10">
                            <div class="custom-control custom-checkbox mt-2">
                                <input type="checkbox" checked class="custom-control-input" id="presalerule" name="presalerule">
                                <label class="custom-control-label text-muted" for="presalerule">I agree <a data-toggle="modal" href="#privacy" data-backdrop="static" data-keyboard="false">PRESALE RULE</a></label>
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" name="tab" id="tab" value="parity">
                <div class="modal-footer">
                    <a type="button" class="pull-left btn btn-sm closebtn" data-dismiss="modal">CANCEL</a>
                    <button type="button" onclick="submitContract()" class="pull-left btn btn-sm btn-blue">CONFIRM</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="alert" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body" id="alertmessage"> </div>
            <div class="text-right pb-1 pr-2">
                <a type="button" class="text-info" data-dismiss="modal">OK</a>
            </div>
        </div>
    </div>
</div>
<div id="loader" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background:transparent; border:none;">
            <div class="text-center pb-1">
                <a type="button" id="closbtnloader" data-dismiss="modal"> <div class="spinner-grow text-success"></div></a></div>

        </div>
    </div>
</div>
<!-- Jquery -->
<script src="assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="assets/js/lib/popper.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<!-- Owl Carousel -->
<script src="assets/js/plugins/owl.carousel.min.js"></script>
<!-- Main Js File -->
<script src="assets/js/app.js"></script>
<script src="assets/js/account.js"></script>
<script src="assets/js/betting.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>


    <script>
        $(document).ready(function () {
            setInterval(function() {
                start_count_down();
                $('#closbtnloader').click();
            }, 1e3);

            getResultbyCategory('parity','parity');
            getUserOrder(1, document.getElementById('activeCategory').value)
        });

        $(document).ready(function() {
            $(".data-row").click(function() {
                $(this).next(".hidden-details").toggle();
            });
        });

        function start_count_down() {
            $(".showload").hide();
            $(".none").show();
            var countDownDate = Date.parse(new Date) / 1e3;
            var now = new Date().getTime();
            var distance = 180 - countDownDate % 180;
            //alert(distance);
            var i = distance / 60,
                n = distance % 60,
                o = n / 10,
                s = n % 10;
            var minutes = Math.floor(i);
            var seconds = ('0'+Math.floor(n)).slice(-2);

            document.getElementById("demo").innerHTML = "<span class='timer'>0"+Math.floor(minutes)+"</span>" + "<span>:</span>" +"<span class='timer'>"+seconds+"</span>";
            document.getElementById("counter").value = distance;

            if( distance === 178 || distance === 174){
                generateGameid();
                let activeCategory = document.getElementById('activeCategory').value
                getResultbyCategory(activeCategory, activeCategory);
                getUserOrder(1, document.getElementById('activeCategory').value);
            }

            $(".gbutton").prop('disabled', distance <= 30 )
        }

        function generateGameid() {
            $.ajax({
                type: "GET",
                url: "universal.php",
                success: function (response) {
                    document.getElementById("gameid").innerHTML = response.gameId;
                    document.getElementById("inputgameid").value = response.gameId;
                    document.getElementById("futureid").value = response.gameId;
                    document.getElementById("balance").innerHTML = response.balance;
                    return false;
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

        function betbutton(color,type,name) {
            if (type === 'number'){
                $(".paymentheader").css("background-color", color);
                document.getElementById('chn').innerHTML = 'Select '+ name;

            }else{
                $(".paymentheader").css("background-color", color);
                document.getElementById('chn').innerHTML = 'Join '+ name;
            }
            $('#payment').modal({backdrop: 'static', keyboard: false})
            $('#payment').modal('show');
            document.getElementById('type').value = type;
            document.getElementById('value').value = name;

        }

        function submitContract() {
            $("#spinner-div").show();
            $("#spinner-div").css('display', 'flex');
            $.ajax({
                type: 'POST',
                data: {
                    amount: document.getElementById('finalamount').value,
                    category: document.getElementById('activeCategory').value,
                    selection: document.getElementById('value').value,
                    gameId : document.getElementById('gameid').innerHTML,
                    userId : document.getElementById('userid').value,
                },

                url: "trade.php",
                success: function (response) {
                    document.getElementById('balance').innerHTML = response.balance
                    document.getElementById('myOrdersDataTable').innerHTML = ''
                    document.getElementById('myOrdersDataTable').innerHTML = response.orders

                    successHandler('Order Successfull')
                },
                error: function (err) {
                    if (err.status === 401) {
                        window.location.href = 'login.php';
                    }
                    errorHandler(err.responseJSON.message)
                }
            });

            $('#payment').modal({backdrop: 'static', keyboard: false})
            $('#payment').modal('hide');
        }

        //=====================amount calculation======================
        function contract(abc) { //alert(abc);
            var amount =$("#amount").val();
            document.getElementById('contractmoney').value = abc;
            var addvalue=abc*amount;
            document.getElementById('showamount').innerHTML = addvalue;
            document.getElementById('finalamount').value = addvalue;

        };
        function addvalue() {
            var amount =$("#amount").val();
            var contractmoney =$("#contractmoney").val();
            var addvalue=contractmoney*amount;
            document.getElementById('showamount').innerHTML = addvalue;
            document.getElementById('finalamount').value = addvalue;
        }

        function tabname(tabname){
            document.getElementById('tab').value = tabname;
        }

        //=====================amount calculation======================


        function getUserOrder(callingForPage, category = 'parity')
        {
            if (callingForPage > 1) {
                document.getElementById('recordsPreviousButton').style.display = 'block';
            } else {
                document.getElementById('recordsPreviousButton').style.display = 'none';
            }

            document.getElementById('activePageForRecords').value = callingForPage;

            $.ajax({
                type: "get",
                data: {
                    getuserOrdersOnly : true,
                    category : category,
                    page : callingForPage,
                    userId : document.getElementById('userid').value,
                },
                url: "universal.php",
                success: function (response) {
                    document.getElementById('myOrdersDataTable').innerHTML = response.orders;
                    successHandler();
                    return false;
                },
                error: function (e) {
                    if (e.status === 401) {
                        window.location.href = 'login.php';
                    }
                    errorHandler()
                    $("#spinner-div").show();
                    $("#spinner-div").css('display', 'flex');
                }
            });
        }
        //====================== get Result==============================

        function getResultbyCategory(category,containerid, page = 1, limit = 10,) {
            const container = containerid;
            if (page > 1) {
                document.getElementById('previousButton').style.display = 'block';
            } else {
                document.getElementById('previousButton').style.display = 'none';
            }

            document.getElementById('activeCategory').value = category
            document.getElementById('activePage').value = page


            $("#spinner-div").show();
            $("#spinner-div").css('display', 'flex');

            $.ajax({
                type: "get",
                data: {
                    category : category,
                    limit : limit,
                    page : page,
                    userId : document.getElementById('userid').value,
                },
                url: "universal.php",
                success: function (response) {
                    document.getElementById("gameid").innerHTML = response.gameId;
                    document.getElementById("inputgameid").value = response.gameId;
                    document.getElementById("futureid").value = response.gameId;
                    document.getElementById("balance").innerHTML = response.balance;
                    document.getElementById(container).innerHTML = ''
                    document.getElementById(container).innerHTML = response.types[category]

                    successHandler();
                    return false;
                },
                error: function (e) {
                    if (e.status === 401) {
                        window.location.href = 'login.php';
                    }
                    errorHandler()
                    $("#spinner-div").show();
                    $("#spinner-div").css('display', 'flex');
                }
            });
        }

    </script>
</body>
</html>