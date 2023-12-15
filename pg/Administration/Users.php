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
<!-- Modal -->
<div class="modal fade" id="CreateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-4 card-nblue">

<form action="" method="post">
    <div class="form-group">
      <label class="text-white">PAN Number</label>
      <input type="text" class="form-control form-control-sm" id="pan_no" minlength="12" maxlength="10"  name="pan_no" onchange="panValidation(this.value)" placeholder="PAN Number" required>
    </div>
    <div class="form-group">
      <label class="text-white">Name as per PAN</label>
      <input type="text" class="form-control form-control-sm" maxlength="50" name="name" placeholder="Name as per PAN" required>
    </div>
    <div class="form-group">
      <label class="text-white">Bussiness Name</label>
      <input type="text" class="form-control form-control-sm" maxlength="50" name="company_name" placeholder="Bussiness Name" required>
    </div>
    <div class="form-group">
      <label class="text-white">Aadhaar Number</label>
      <input type="text" class="form-control form-control-sm" placeholder="Aadhaar Number" name="uid_no" minlength="12" maxlength="12" onkeypress="return isNumber(event)" required>
    </div>
    <div class="form-group">
      <label class="text-white">Email Address</label>
      <input type="email" class="form-control form-control-sm" placeholder="Email Address" name="email" maxlength="50" required>
    </div>
    <div class="form-group">
      <label class="text-white">Mobile Number</label>
      <input type="text" class="form-control form-control-sm" placeholder="Mobile Number" name="mobile" minlength="10" maxlength="10" onkeypress="return isNumber(event)" required>
    </div>
     <div class="form-group">
      <label class="text-white">Pricing Slab</label>
      <select id="slab_id" name="slab_id" class="form-control form-control-sm" required>
<?php
$sql = "SELECT * FROM `tb_slab` WHERE status='1' ORDER BY `id` DESC";	
$query  = sql_query($sql);
while($rows = sql_fetch_array($query)){ 
?>
<option value="<?php echo $rows['id'];?>"><?php echo ucwords($rows['name']);?></option>
<?php
}
?>
      </select>
    </div>
    <button type="submit" name="create_account" class="btn bg-white text-dark btn-sm"><i class="fa fa-check-circle"></i> Submit</button>
  </form>

    </div>
  </div>
</div>


<?php
if(isset($_POST['create_account']) && 
!empty($_POST['pan_no']) &&  
!empty($_POST['name']) &&  
!empty($_POST['company_name']) &&  
!empty($_POST['uid_no']) &&  
!empty($_POST['email']) &&  
!empty($_POST['mobile']) &&  
!empty($_POST['slab_id']) ){

$pan_no = safe_str($_POST['pan_no']);
$name = strip_tags($_POST['name']);
$company_name = strip_tags($_POST['company_name']);
$uid_no = safe_str($_POST['uid_no']);
$email = strip_tags($_POST['email']);
$mobile = safe_str($_POST['mobile']);
$slab_id = safe_str($_POST['slab_id']);

$res = sql_query("SELECT * FROM `tb_partner` WHERE pan_no='".$pan_no."' || uid_no='".$uid_no."' || email='".$email."' || mobile='".$mobile."' ");
if(sql_num_rows($res)==''){
$rand = GenRandomString(3).time();  
$pwd = pwd_hash($rand);
$query = sql_query("INSERT INTO tb_partner (`login_id`, `login_pwd`, `name`, `company_name`, `mobile`, `email`, `pan_no`, `uid_no`, `status`, `balance`, `token`, `secret`, `slab`) 
VALUES ('".$pan_no."','".$pwd."','".$name."','".$company_name."','".$mobile."','".$email."','".$pan_no."','".$uid_no."','active','0','".api_token_gen()."','".GenRandomString(10)."','".$slab_id."')");
if($query){
$msg = "Dear $name, Username is:$pan_no, Pwd is:$rand,  Thank you for register, never share with anyone. ".webdata('socket').base_url();
$sms_status = SendSMS($mobile,$msg);      



$email_message = "<html><head><title>Payment Gateway Login Credentials.</title></head><body style='font-family: Arial, Helvetica, sans-serif;'>
    <table style='border:1px solid #ccc;border-radius:8px;' cellpadding='8'>
    <tr><td><img src='" .webdata("company_logo"). "' width='100' style='background: linear-gradient(#0857ab,#11c9cc); border-radius: 10px; padding: 5px;'/></td></tr>
    <tr><td style>Dear " . $name . "</td></tr>
    <tr><td>Your Username: <b>$pan_no</b></td></tr>
    <tr><td>Your Password: <b>$rand</b></td></tr>
  
    <tr><td>We are sharing a Login Credentials to access your account.(<b style='color:red;'>never share with anyone.</b>)</td></tr>
    <tr><td>Thank you</td></tr>
    <tr><td>Admin - " . webdata('company_name') . "</td></tr>
    <tr><td>Email: " . support('email') . "</td></tr>
    <tr><td>Phone: " . support('mobile') . "</td></tr></table></body></html>";
    
$mail_status = SendMail($email, " ".webdata('company_name')." ($name) Login Credentials", $email_message);


echo '<script>swal("Account Created!", "Login Credentials Has Been Sent Mobile Successfully!", "success");</script>';
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}


}else{
echo '<script>setTimeout(function(){ swal("Alert!", "Data Already Exist!", "error"); }, 200);</script>';
redirect('','2000');
}	
	
}
?>

<?php
if(isset($_POST['delete']) && !empty($_POST['uid']) ){
	
$uuid = safe_str($_POST['uid']);
	
$res = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uuid."' ");
$result = sql_num_rows($res);	
if($result>0){
$query = sql_query("DELETE FROM `tb_partner` WHERE id='".$uuid."'  ");
if($query){
echo '<script>swal("Successfully!", "User Deleted!", "success");</script>';
redirect('','1500');	
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}else{
echo '<script>swal("Alert!", "User Not Exist!", "error");</script>';
redirect('','1500');
}	
	
}
?>

<?php
if(isset($_POST['transfer']) && !empty($_POST['uid']) && !empty($_POST['type']) && !empty($_POST['amount']) ){
	
$uuid = safe_str($_POST['uid']);
$amount = safe_str($_POST['amount']);

$type = safe_str($_POST['type']);

$res = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uuid."' ");
$count = sql_num_rows($res);	
$result = sql_fetch_array($res);
if($count>0){
if($type=="debit"){
// Debit   
$account = json_decode(webdata("company_account"),true);
$order_id = GenRandomString();
$newrrn = time();
$closing_balance = $result['balance'] - $amount;	
$res = sql_query("INSERT INTO `tb_transactions`( `user_uid`, `order_id`, `date`, `time`, `type`, `mode`, `pay_upi`, `upi_id`, `rrn`, `txn_amount`, `fees`, `settle_amount`, `closing_balance`, `txn_type`, `remark`, `status`) 
VALUES ('".$result['id']."','$order_id','".date_time("Y-m-d")."','".date_time("h:i:s A")."','Transfer - Admin','DDA','".$account['account']."','".$result['login_id']."','$newrrn','$amount','0','$amount','$closing_balance','DEBIT','Admin','COMPLETED')");

if($res){
if(sql_query("UPDATE `tb_partner` SET balance='".$closing_balance."' WHERE id='".$result['id']."' ")){
echo '<script>swal("Balance Debit Successfully!", "Ref:'.$newrrn.'!", "success");</script>';
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}
    
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

    
// Debit     
}elseif($type=="credit"){
// Credit      
    
$account = json_decode(webdata("company_account"),true);
$order_id = GenRandomString();
$newrrn = time();
$closing_balance = $result['balance'] + $amount;	
$res = sql_query("INSERT INTO `tb_transactions`( `user_uid`, `order_id`, `date`, `time`, `type`, `mode`, `pay_upi`, `upi_id`, `rrn`, `txn_amount`, `fees`, `settle_amount`, `closing_balance`, `txn_type`, `remark`, `status`) 
VALUES ('".$result['id']."','$order_id','".date_time("Y-m-d")."','".date_time("h:i:s A")."','Received - Admin','DCA','".$account['account']."','".$result['login_id']."','$newrrn','$amount','0','$amount','$closing_balance','CREDIT','Admin','COMPLETED')");

if($res){
if(sql_query("UPDATE `tb_partner` SET balance='".$closing_balance."' WHERE id='".$result['id']."' ")){
echo '<script>swal("Balance Credit Successfully!", "Ref:'.$newrrn.'!", "success");</script>';
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}
    
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
} 
    
// Credit       
}else{
echo '<script>swal("Alert!", "Invalid Request!", "error");</script>';
redirect('','1500');   
}	
}else{
echo '<script>swal("Alert!", "User Not Exist!", "error");</script>';
redirect('','1500');
}	
}
?>
<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid">
                  <div class="table-responsive-md">
				  
                    <table class="table table-hover">
					<form action="" method="post"> 
                      <thead>
                        <tr class="card-nblue">
                          <th class="text-white">Total Users</th>
                          <th class="text-white">
						  <button class="btn bg-mix text-white btn-sm btn-block" data-toggle="modal" data-target="#CreateUser" type="button">Create User <i class="fa fa-plus"></i></button>
						  </th>
						  
                          <th class="text-white">
						  <input type="number" name="rows_input" value="10" class="form-control form-control-sm" placeholder="Show entries">
						  </th>
						  
<th class="text-white" colspan="5">
<div class="input-group">
<input class="form-control form-control-sm" name="search_input" placeholder="Login ID / Name / Mobile / Email / PAN / Aadhaar" style=" height: 30.1px; ">
<div class="input-group-append">
<button class="btn bg-mix text-white btn-sm" name="filter" type="submit"><i class="fa fa-search"></i></button>
</div>
</div>
</th>
<th class="text-white">
<button class="btn bg-mix text-white btn-sm" onclick="Export('UPIsAccount')"  type="button">Export <i class="fa fa-external-link-alt"></i></button>
</th>
						  
                        </tr>
                      </thead>
					</form>
					
                      <thead>
                        <tr class="bg-mix">
                          <th class="text-white">USERNAME</th>
                          <th class="text-white">PAN/COMPANY</th>
                          <th class="text-white">AADHAAR/NAME</th>
                          <th class="text-white">BALANCE/SLAB</th>
                          <th class="text-white">CREDENTIALS</th>
                          <th class="text-white">SETTLE ACCOUNT</th>
                          <th class="text-white">STATUS</th>
                          <th class="text-white">TRANSFER</th>
                          <th class="text-white">ACTION</th>
						  
                        </tr>
                      </thead>
                      <tbody>
<?php
$sql = "SELECT * FROM `tb_partner` ORDER BY `id` DESC ";	

if(isset($_POST['filter']) AND  
!empty($_POST['rows_input']) ){
	
$rows_input = safe_str($_POST['rows_input']);
$search_input = safe_str($_POST['search_input']);
$concat = '';
if($search_input!=''){
$concat	= " CONCAT(`login_id`,`name`,`mobile`,`email`,`pan_no`,`uid_no`) LIKE '%$search_input%' ";
}
	
$sql = "SELECT * FROM `tb_partner` WHERE $concat ORDER BY `id` DESC LIMIT $rows_input ";	
 
}

$query  = sql_query($sql);
$sl = 1;
while($rows = sql_fetch_array($query)){ 
    
$sql = sql_query("SELECT * FROM `tb_slab` WHERE id='".$rows['slab']."'  ");
$tb_slab = sql_fetch_array($sql);

$account = json_decode($rows['settle_account'],true);


$status = "<button class='btn btn-danger btn-sm'>".ucwords($rows['status'])."</button>";
if($rows['status']=="active"){
$status = "<button class='btn btn-success btn-sm'>".ucwords($rows['status'])."</button>";    
}    
?>						  
						<tr>
                          <td><?php echo $rows['login_id'];?><br><?php echo $rows['mobile'];?><br><?php echo $rows['email'];?></td>
						  <td><?php echo $rows['pan_no'];?><br><?php echo $rows['company_name'];?></td>
                          <td><?php echo $rows['uid_no'];?><br><?php echo $rows['name'];?></td>
                          <td>₹<?php echo moneyformat($rows['balance']);?><br><?php echo $tb_slab['name'];?></td>
                          <td><p id="<?php echo $sl;?>" style='display:none;'>{"token":"<?php echo $rows['token'];?>","secret":"<?php echo $rows['secret'];?>"}</p>
                          <button class="btn btn-sm "onclick="copyToClipboard('#<?php echo $sl;?>')">Copy Key</button></td>
                          <td><span style="font-size:12px"><?php echo strtoupper($account['account_no']);?><br><?php echo strtoupper($account['beneficiary_name']);?><br><?php echo strtoupper($account['ifsc']);?></span></td>
                          <td><?php echo $status;?></td>
                          <td>
<form action='' method='post' style="width: 150px;">
<input type='hidden' name='uid' value='<?php echo $rows['id'];?>'>
<div class="input-group input-group-sm mb-2">
 <input type='text' name='amount' placeholder='Amount'  class='form-control form-control-sm mb-2' onkeypress="return isNumber(event)" required>
  <div class="input-group-append">
    <select name='type' class='form-control form-control-sm' style="width: 73px;" required>
	<option value='debit'>Debit</option>
	<option value='credit'>Credit</option>
	</select>
  </div>
</div>
<input type='submit' name='transfer' class='btn btn-primary btn-sm btn-block' onclick="return confirm('Are you sure?')" value='Submit'>
</form>    
                          </td>
                          <td>
<form action="UsersUpdate" method="get"> 
<input type="hidden" name="uid" value="<?php echo $rows['id'];?>">
<button name="update" value="true" class="btn btn-primary btn-sm mb-2">Update <i class="fa fa-bolt"></i></button>
</form>
<form action="" method="post"> 
<input type="hidden" name="uid" value="<?php echo $rows['id'];?>">
<button name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure Delete?')">Delete <i class="fa fa-trash"></i></button>
</form>
</td>
                        </tr>
<?php
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