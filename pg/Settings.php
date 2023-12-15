<?php
require_once('layouts/header.php');

$account = json_decode($userdata['settle_account']);
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
<?php
if(isset($_POST['pwdupdate']) && !empty($_POST['current_pwd']) && !empty($_POST['new_pwd']) && !empty($_POST['confirm_new_pwd']) ){
	
$current_pwd = safe_str($_POST['current_pwd']);
$new_pwd = safe_str($_POST['new_pwd']);
$confirm_new_pwd = safe_str($_POST['confirm_new_pwd']);
$pwd = $userdata['login_pwd'];
if(pwd_verify($current_pwd,$pwd)){
	
if($new_pwd==$confirm_new_pwd){

if(sql_query("UPDATE `tb_partner` SET login_pwd='".pwd_hash($confirm_new_pwd)."' WHERE id='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Password Changed!", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}else{
echo '<script>swal("Alert!", "Confirm Password Not Match!", "error");</script>';
redirect('','1500');
}	
	
}else{
echo '<script>swal("Alert!", "Current Password Not Match!", "error");</script>';
redirect('','1500');
}


}
?>

<?php
if(isset($_POST['userupdate']) && 
!empty($_POST['mobile']) && 
!empty($_POST['email']) && 
!empty($_POST['account_no'])&& 
!empty($_POST['beneficiary_name'])&& 
!empty($_POST['ifsc']) ){
	
$mobile = safe_str($_POST['mobile']);
$email = safe_str($_POST['email']);
$account_no = safe_str($_POST['account_no']);
$beneficiary_name = safe_str($_POST['beneficiary_name']);
$ifsc = safe_str($_POST['ifsc']);

$settle_account = json_encode(array("account_no"=>$account_no, "beneficiary_name"=>$beneficiary_name, "ifsc"=>$ifsc));

if(sql_query("UPDATE `tb_partner` SET mobile='".$mobile."', email='".$email."', settle_account='".$settle_account."' WHERE id='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Profile Updated!", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}
?>

<?php
if(isset($_POST['generate'])){
	
$token = api_token_gen();
$secret = GenRandomString(10);

if(sql_query("UPDATE `tb_partner` SET token='".$token."', secret='".$secret."' WHERE id='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Generate New Credentials!", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}
?>

<?php
if(isset($_POST['webhookupdate']) && !empty($_POST['txn_status_webhook'])){

$json_string = json_encode(array(
"txnStatus"=>'TXN_SUCCESS', 
"resultInfo"=>'Txn Success',
"orderId"=>time(),
"txnAmount"=>rand(000,999),
"txnId"=>GenRandomString(12),
"bankTxnId"=>rand(0000,9999),
"paymentMode"=>'UPI',
"txnDate"=>date_time("Y-m-d h:i:s A"),
"utr"=> '0000'.rand(00000000,99999999),
"sender_vpa"=>'demosender@bankupi',
"sender_name"=>'DEMO SENDER',
"sender_note"=>'Test Txn',
"payee_vpa"=>webdata("upi_prefix").rand(0000,9999).webdata("upi_bank"),
));	

$hash = hash_encrypt($json_string, $userdata['secret']);
//hash_decrypt($hash,$userdata['secret']);
$arr = array(
"status"=>'SUCCESS', 
"message"=>'Test Transactions',
"hash"=>$hash
);

$post_data = json_encode($arr);
$txn_status_webhook = safe_str($_POST['txn_status_webhook']);
$res = curl_post($txn_status_webhook,$post_data,'');

if(sql_query("UPDATE `tb_partner` SET txn_status_webhook='".$txn_status_webhook."' WHERE id='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Updated Transaction Status Webhook Url!", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}
?>
<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid card-nblue">
                <div class="row p-4">
                <div class="col-md-4 mb-4">
				<h4 class="text-white">Account Settings</h4><hr class="bg-white">
<form action="" method="post">
   
    <div class="form-group">
      <label class="text-white">📢Company Name</label>
      <input type="text" name="company_name" value="<?php echo $userdata['company_name'];?>" class="form-control form-control-sm" placeholder="Company Name" readonly>
    </div>
	
	<div class="form-group">
      <label class="text-white">📮PAN Number</label>
      <input type="text" name="pan_no" value="<?php echo $userdata['pan_no'];?>" class="form-control form-control-sm" placeholder="PAN Number" readonly>
    </div>
	
	<div class="form-group">
      <label class="text-white">🔏Current Password</label>
      <input type="text" name="current_pwd" class="form-control form-control-sm" placeholder="Current Password" maxlength="12" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">🔏New Password</label>
      <input type="text" name="new_pwd" class="form-control form-control-sm" placeholder="New Password" maxlength="12" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">🔏Confirm New Password</label>
      <input type="text" name="confirm_new_pwd" class="form-control form-control-sm" placeholder="Confirm New Password" maxlength="12" required>
    </div>
	
	
    <button type="submit" name="pwdupdate" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Change Password</button>
    
</form> 
				
			  
			   
                </div>
                <div class="col-md-4 mb-4">
				<h4 class="text-white">User Profile</h4><hr class="bg-white">
<form action="" method="post">
   
	<div class="form-group">
      <label class="text-white">🚀Mobile Number</label>
      <input type="text" name="mobile" value="<?php echo $userdata['mobile'];?>" class="form-control form-control-sm" placeholder="Mobile Number" maxlength="10" onkeypress="return isNumber(event)" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">📥Email Address</label>
      <input type="email" name="email" value="<?php echo $userdata['email'];?>" class="form-control form-control-sm" placeholder="Email Address" maxlength="50" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">📌Phone Number</label>
      <input type="text" name="account_no" value="<?php echo $account->account_no;?>" class="form-control form-control-sm" placeholder="Account Number" maxlength="34" required>
    </div>	
	
    <div class="form-group">
      <label class="text-white"> 📌Name</label>
      <input type="text" name="beneficiary_name" value="<?php echo $account->beneficiary_name;?>" class="form-control form-control-sm" placeholder="Beneficiary Name" minlength="5" maxlength="35" required>
    </div>
	
    <div class="form-group">
      <label class="text-white">⌛Extra</label>
      <input type="text" name="ifsc" value="<?php echo $account->ifsc;?>" class="form-control form-control-sm" placeholder="IFSC" minlength="11" maxlength="11" required>
    </div>
	
	
    <button type="submit" name="userupdate" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Update</button>
    
</form> 
				
			  
			   
                </div>	
				
                <div class="col-md-4 mb-4">
				<h4 class="text-white">Api Credentials</h4><hr class="bg-white">
<form action="" method="post">
   
	<div class="form-group">
      <label class="text-white">🔑Production Api Token</label>
      <input type="text" name="token" value="<?php echo $userdata['token'];?>" class="form-control form-control-sm" placeholder="Api Token" readonly>
    </div>
	
	<div class="form-group">
      <label class="text-white">🔐Production Secret Key</label>
      <input type="text" name="secret" value="<?php echo $userdata['secret'];?>" class="form-control form-control-sm" placeholder="Secret Key" readonly>
    </div>
	
	<div class="form-group">
      <label class="text-white">📎Transaction URL</label>
      <input type="text" name="txn_url" value="<?php echo webdata('socket');?><?php echo base_url();?>/order/paytm" class="form-control form-control-sm" placeholder="Transaction URL" readonly>
    </div>
	
	<div class="form-group">
      <label class="text-white">🗜Transaction Status URL</label>
      <input type="text" name="txn_status_url" value="<?php echo webdata('socket');?><?php echo base_url();?>/order/status" class="form-control form-control-sm" placeholder="Transaction Status URL" readonly>
    </div>
	
	<div class="form-group">
      <label class="text-white">🧪Test Transaction URL</label>
      <input type="text" name="stage" value="<?php echo webdata('socket');?><?php echo base_url();?>/stage/process" class="form-control form-control-sm" placeholder="Test Transaction URL" readonly>
    </div>
	
	<!--div class="form-group">
      <label class="text-white">🛒Transaction Status Webhook</label>
      <input type="text" name="txn_status_webhook" value="<?php echo $userdata['txn_status_webhook'];?>" class="form-control form-control-sm" placeholder="Transaction Status Webhook Url">
    </div-->
	
    <!--button type="submit" name="webhookupdate" class="btn bg-white text-dark btn-sm mr-2"><i class="fa fa-bolt"></i> Submit</button-->
    <button type="submit" name="generate" class="btn bg-white text-dark btn-sm"><i class="fa fa-key"></i> Generate Credentials</button>
    
</form> 
				
			  
			   
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