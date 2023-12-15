<?php
require_once('layouts/header.php');
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
<?php
if(isset($_POST['completed']) && !empty($_POST['tid']) ){
	
$tid = safe_str($_POST['tid']);

$res = sql_query("SELECT * FROM `tb_virtualtxn` WHERE client_orderid='0' AND id='".$tid."' AND user_id= '".$userdata['id']."' ");
$row = sql_num_rows($res);	
$result = sql_fetch_array($res);
if($row==1){

if(sql_query("UPDATE `tb_virtualtxn` SET client_orderid='".time()."' WHERE id='".$result['id']."'  AND user_id= '".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Transactions Completed!", "success");</script>';	
redirect('','1500');
}else{
echo '<script>swal("Alert!", "Server is Down!", "error");</script>';
redirect('','2000');
}

}else{
echo '<script>swal("Alert!", "Transactions Not Exist!", "error");</script>';
redirect('','2000');
}	
	
}
?>

<?php
if(isset($_POST['completed_all'])){
	
$tid = safe_str($_POST['tid']);

$query = sql_query("SELECT * FROM `tb_virtualtxn` WHERE client_orderid='0' AND user_id= '".$userdata['id']."' ");
$row = sql_num_rows($query);	
if($row>0){
$result = array();  
$x =1;
while($rows = sql_fetch_array($query)){ 
$orid = time()+$x; 
$res = sql_query("UPDATE `tb_virtualtxn` SET client_orderid='".$orid."' WHERE id='".$rows['id']."' ");
$result[] = $res;
$x++;}

if(array_key_exists(0,$result)){
echo '<script>swal("Successfully!", "All Transactions Completed!", "success");</script>';	
redirect('','1500');
}else{
echo '<script>swal("Alert!", "Server is Down!", "error");</script>';
redirect('','2000');
}


}else{
echo '<script>swal("Alert!", "Warning Transactions Not Exist!", "error");</script>';
redirect('','2000');
}	
	
}
?>
<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid">
                  <div class="table-responsive">
				  
                    <table class="table table-hover">
					<form action="" method="post"> 
                      <thead>
                        <tr class="card-nblue">
                          <th class="text-white">🔖Account Detail</th>
                          <th class="text-white">🏷Transactions Details</th>
						  <th class="text-white">
						  <input type="date" name="from_date" value="<?= date_time("m/d/Y")?>" class="form-control form-control-sm">
						  </th>
						  
						  <th class="text-white">
						  <input type="date" name="to_date" value="<?= date_time("m/d/Y")?>" class="form-control form-control-sm">
						  </th>
						  
                          <th class="text-white">
						  <input type="number" name="rows_input" value="10" class="form-control form-control-sm" placeholder="Show entries">
						  </th>
						  
<th class="text-white" colspan="2">
<div class="input-group">
<input class="form-control form-control-sm" name="search_input" placeholder="Search ID / Bank Ref Number" style=" height: 30.1px; ">
<div class="input-group-append">
<button class="btn bg-mix text-white btn-sm" name="filter" type="submit"><i class="fa fa-search"></i></button>
</div>
</div>
</th>
<th class="text-white">
<button class="btn bg-mix text-white btn-sm" onclick="Export('Transactions')"  type="button">Export <i class="fa fa-external-link-alt"></i></button>
</th>
<th class="text-white">
<form action="" method="post">     
<button class="btn bg-mix text-white btn-sm" name="completed_all" type="submit">Completed All <i class="fa fa-check-circle"></i></button>
</form>
</th>
						  
                        </tr>
                      </thead>
					</form>
					
                      <thead>
                        <tr class="bg-mix">
                          <th class="text-white">📢ID</th>
                          <th class="text-white">⏰Time</th>
                          <th class="text-white">⚡Type</th>
                          <th class="text-white">🔺️Customer</th>
                          <th class="text-white">💰Amount</th>
                          <th class="text-white">🔖UTR Number</th>
                          <th class="text-white">📗Remark</th>
                          <th class="text-white">📱AppName</th>
                          <th class="text-white">🛡Status</th>
						  
                        </tr>
                      </thead>
                      <tbody>
<?php
$sql = "SELECT * FROM `tb_virtualtxn` WHERE user_id='".$userdata['id']."' ORDER BY `id` DESC ";	
$from_date = date_time("Y-m-d");
$to_date = date_time("Y-m-d");

if(isset($_POST['filter']) AND 
!empty($_POST['from_date']) AND 
!empty($_POST['to_date']) AND 
!empty($_POST['rows_input']) ){
	
$from_date = date("Y-m-d", strtotime($_POST['from_date']));	
$to_date = date("Y-m-d", strtotime($_POST['to_date']));	
$rows_input = safe_str($_POST['rows_input']);
$search_input = safe_str($_POST['search_input']);
$concat = '';
if($search_input!=''){
$concat	= " CONCAT(`txn_id`,`bank_ref_num`) LIKE '%$search_input%' AND ";
}


$sql = "SELECT * FROM `tb_virtualtxn` WHERE $concat user_id='".$userdata['id']."' ORDER BY `id` DESC LIMIT $rows_input ";	
 
}

$query  = sql_query($sql);
$sl = 1;
while($rows = sql_fetch_array($query)){ 

$result = json_decode($rows['results'],true);

if($rows['credited_at']>=$from_date." 00:00:00" and $rows['credited_at']<=$to_date." 23:59:59"){

if($result['packageName']==""){

$appName = 'Paytm Business';
if($result['packageName']=="net.one97.paytm"){
$appName = "Paytm";    
}elseif($result['packageName']=="com.sbi.upi"){
$appName = "SBI Pay";    
}

$status = "<b class='text-success'>COMPLETED</b>";
if(filter_var($rows['client_orderid'], FILTER_SANITIZE_NUMBER_INT)==0){
$status = "<b class='text-danger'>WARNING</b>";   
}

$client_orderid = '
<form action="" method="post"> 
<input type="hidden" name="tid" value="'.$rows['id'].'">
<button name="completed" class="btn bg-mix text-white btn-xs">Completed <i class="fa fa-check-circle"></i></button>
</form>';
if(filter_var($rows['client_orderid'], FILTER_SANITIZE_NUMBER_INT)>0){ 
$client_orderid = $rows['client_orderid']; 
}
?>						  

						<tr>
                          <td>#<?php echo $rows['txn_id'];?><br><?=$client_orderid?></td>
                          <td><?php echo $rows['credited_at'];?></td>
                          <td><?php echo strtoupper($rows['bene_account_no']);?><br>Received - <?php echo $rows['payment_type'];?></td>
                          <td><?php echo explode(" - ",$rows['rmtr_account_no'])[0];?><br><?php echo strtoupper($rows['rmtr_full_name']);?></td>
                          <td>₹<?php echo moneyformat($rows['amount']);?></td>
                          <td><?php echo $rows['bank_ref_num'];?></td>
                          <td style="font-size: 12px;"><?php echo $rows['rmtr_to_bene_note'];?></td>
                          <td><?php echo strtoupper($appName);?></td>
                          <td><?=$status?></td>
                        </tr>
<?php
}

}

$sl++;}
?>											
						
                      </tbody>
                    </table>
					
					<div class="row">
					<div class="col-sm-12 col-md-5">
					
					</div>
					</div>
					
                  </div>
                </div>
              </div>
            </div>

            
            
          </div>
        </div>
      </div>
<?php
require_once('layouts/footer.php');
?>