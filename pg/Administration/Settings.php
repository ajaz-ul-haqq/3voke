<?php
require_once('layouts/header.php');

$account = json_decode(webdata("company_account"));
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
<?php
if(isset($_POST['company_update']) && 
!empty($_POST['company_name']) && 
!empty($_POST['company_about']) && 
!empty($_POST['web_tag']) && 
!empty($_POST['web_rights']) && 
!empty($_POST['mobile']) && 
!empty($_POST['mobile1']) && 
!empty($_POST['email'])  ){
	
$company_name = safe_str($_POST['company_name']);
$company_about = safe_str($_POST['company_about']);
$web_tag = safe_str($_POST['web_tag']);
$web_rights = safe_str($_POST['web_rights']);
$mobile = safe_str($_POST['mobile']);
$mobile1 = safe_str($_POST['mobile1']);
$email = safe_str($_POST['email']);
$socket = safe_str($_POST['socket']);
$base_url = strip_tags($_POST['base_url']);


$arr = array("mobile"=>$mobile, "mobile1"=>$mobile1, "email"=>$email);
$support = json_encode($arr);

if(sql_query("UPDATE `tb_settings` SET socket='".$socket."', base_url='".$base_url."', company_name='".$company_name."', company_about='".$company_about."', web_tag='".$web_tag."', web_rights='".$web_rights."', support='".$support."' WHERE uid='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Company Details Updated!", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}
	
	

}
?>


<?php
if(isset($_POST['company_account']) && 
!empty($_POST['account']) && 
!empty($_POST['name']) && 
!empty($_POST['ifsc']) && 
!empty($_POST['slab_id']) && 
!empty($_POST['upi_prefix']) && 
!empty($_POST['upi_bank']) && 
!empty($_POST['hypto_token'])  && 
!empty($_POST['authorization']) ){
	
$account = safe_str($_POST['account']);
$name = safe_str($_POST['name']);
$ifsc = strip_tags($_POST['ifsc']);
$slab_id = safe_str($_POST['slab_id']);
$upi_prefix = safe_str($_POST['upi_prefix']);
$upi_bank = safe_str($_POST['upi_bank']);
$hypto_token = strip_tags($_POST['hypto_token']);
$authorization = strip_tags($_POST['authorization']);


$arr = array("account"=>$account, "name"=>$name, "ifsc"=>$ifsc);
$company_account = json_encode($arr);

if(sql_query("UPDATE `tb_settings` SET company_account='".$company_account."',  slab_id='".$slab_id."',  upi_prefix='".$upi_prefix."',  upi_bank='".$upi_bank."', hypto_token='".$hypto_token."',  authorization='".$authorization."' WHERE uid='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Account Details Updated!", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}
	
	

}
?>

<?php
if(isset($_POST['api_update']) && 
!empty($_POST['username']) && 
!empty($_POST['password']) && 
!empty($_POST['smsurl']) && 
!empty($_POST['app_link']) && 
!empty($_POST['web_fav']) && 
!empty($_POST['company_logo']) && 
!empty($_POST['live_chat'])  ){
	
$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);
$smsurl = strip_tags($_POST['smsurl']);
$app_link = strip_tags($_POST['app_link']);
$web_fav = strip_tags($_POST['web_fav']);
$company_logo = strip_tags($_POST['company_logo']);
$live_chat = str_escape($_POST['live_chat']);


$arr = array("username"=>$username, "password"=>$password, "smsurl"=>$smsurl);
$smsapi = json_encode($arr);

if(sql_query("UPDATE `tb_settings` SET smsapi='".$smsapi."',  app_link='".$app_link."',  web_fav='".$web_fav."',  company_logo='".$company_logo."',  live_chat='".$live_chat."' WHERE uid='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Api Credentials Updated!", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}
	
	

}
?>

<?php
if(isset($_POST['notification_update']) && 
!empty($_POST['notification'])  ){
	
$notification = $_POST['notification'];


if(sql_query("UPDATE `tb_settings` SET notification='".$notification."' WHERE uid='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Notification Updated!", "success");</script>';
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
				<h4 class="text-white">Company Settings</h4><hr class="bg-white">
<form action="" method="post">
   
    <div class="form-group">
      <label class="text-white">Company Name</label>
      <input type="text" name="company_name" value="<?php echo webdata('company_name');?>" class="form-control form-control-sm" placeholder="Company Name" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">Company Address</label>
      <textarea type="text" name="company_about" class="form-control form-control-sm" placeholder="Company Address" required><?php echo webdata('company_about');?></textarea>
    </div>
	
	<div class="form-group">
      <label class="text-white">Web Tag</label>
      <input type="text" name="web_tag" value="<?php echo webdata('web_tag');?>"  class="form-control form-control-sm" placeholder="Web Tag" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">Web Rights</label>
      <input type="text" name="web_rights" value="<?php echo webdata('web_rights');?>"  class="form-control form-control-sm" placeholder="Web Rights" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">WhatsApp Number</label>
      <input type="text" name="mobile" value="<?php echo support('mobile');?>"  class="form-control form-control-sm" placeholder="WhatsApp Number" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">Mobile Number</label>
      <input type="text" name="mobile1" value="<?php echo support('mobile1');?>"  class="form-control form-control-sm" placeholder="Mobile Number" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">Email Address</label>
      <input type="text" name="email" value="<?php echo support('email');?>"  class="form-control form-control-sm" placeholder="Email Address" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">Base URL</label>
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <select id="socket" name="socket" class="form-control form-control-sm" required>
      <option value="https://">https</option>  
      <option value="http://">http</option> 
    </select>
  </div>
  <input type="text" name="base_url" value="<?php echo webdata('base_url');?>"  class="form-control form-control-sm" placeholder="Base URL" required>
</div>
    </div>
<script>
document.getElementById("socket").value = "<?php echo webdata('socket');?>";
</script>	
    <button type="submit" name="company_update" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Update</button>
    
</form> 
				
			  
			   
                </div>
                <div class="col-md-4 mb-4">
				<h4 class="text-white">Company Account</h4><hr class="bg-white">
<form action="" method="post">
    
	<div class="form-group">
      <label class="text-white">Account Number</label>
      <input type="text" name="account" value="<?php echo $account->account;?>" class="form-control form-control-sm" placeholder="Account Number" maxlength="34" required>
    </div>	
	
    <div class="form-group">
      <label class="text-white">Beneficiary Name</label>
      <input type="text" name="name" value="<?php echo $account->name;?>" class="form-control form-control-sm" placeholder="Beneficiary Name" minlength="5" maxlength="35" required>
    </div>
	
    <div class="form-group">
      <label class="text-white">IFSC</label>
      <input type="text" name="ifsc" value="<?php echo $account->ifsc;?>" class="form-control form-control-sm" placeholder="IFSC" required>
    </div>
    
    <div class="form-group">
      <label class="text-white">UPI Pricing Slab</label>
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
<script>
document.getElementById("slab_id").value = "<?php echo webdata('slab_id');?>";
</script>    
    <div class="form-group">
      <label class="text-white">UPI Prefix</label>
      <input type="text" name="upi_prefix" value="<?php echo webdata('upi_prefix');?>" class="form-control form-control-sm" placeholder="UPI Prefix" required>
    </div>
    
    
    <div class="form-group">
      <label class="text-white">UPI Bank</label>
      <input type="text" name="upi_bank" value="<?php echo webdata('upi_bank');?>" class="form-control form-control-sm" placeholder="@bankname" required>
    </div>
	
    <div class="form-group">
      <label class="text-white">Hypto Token</label>
      <input type="text" name="hypto_token" value="<?php echo webdata('hypto_token');?>" class="form-control form-control-sm" placeholder="Hypto Token" required>
    </div>
    
    <div class="form-group">
      <label class="text-white">Authorization</label>
      <input type="text" name="authorization" value="<?php echo webdata('authorization');?>" class="form-control form-control-sm" placeholder="Authorization" required>
    </div>
	
    <button type="submit" name="company_account" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Update</button>
    
</form> 
				
			  
			   
                </div>	
				
                <div class="col-md-4 mb-4">
				<h4 class="text-white">Api Credentials</h4><hr class="bg-white">
<form action="" method="post">
    
	<div class="form-group">
      <label class="text-white">SMS API UserId</label>
      <input type="text" name="username" value="<?php echo smsdata("username");?>" class="form-control form-control-sm" placeholder="SMS API UserId" required>
    </div>	
	
    <div class="form-group">
      <label class="text-white">SMS API Pwd</label>
      <input type="text" name="password" value="<?php echo smsdata("password");?>" class="form-control form-control-sm" placeholder="SMS API Pwd" required>
    </div>
	
    <div class="form-group">
      <label class="text-white">SMS Api Url</label>
      <input type="url" name="smsurl" value="<?php echo smsdata("smsurl");?>" class="form-control form-control-sm" placeholder="SMS Api Url" required>
    </div>
       
    <div class="form-group">
      <label class="text-white">App Link</label>
      <input type="url" name="app_link" value="<?php echo webdata('app_link');?>" class="form-control form-control-sm" placeholder="App Link" required>
    </div>
    
    <div class="form-group">
      <label class="text-white">Favicon Link</label>
      <input type="url" name="web_fav" value="<?php echo webdata('web_fav');?>" class="form-control form-control-sm" placeholder="Favicon Link" required>
    </div>
    
    <div class="form-group">
      <label class="text-white">Brand Logo Link</label>
      <input type="url" name="company_logo" value="<?php echo webdata('company_logo');?>" class="form-control form-control-sm" placeholder="Brand Logo Link" required>
    </div>
    
    <div class="form-group">
      <label class="text-white">Live Chat</label>
      <textarea type="text" name="live_chat" class="form-control form-control-sm" placeholder="Live Chat Script" style="height:110px;" required><?php echo webdata('live_chat');?></textarea>
    </div>
	
    <button type="submit" name="api_update" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Update</button>
    
</form> 
				
			  
			   
                </div>	
                
<div class="col-md-12 mb-4">
<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>		    
<h4 class="text-white">Notification</h4><hr class="bg-white">		
			
<form action="" method="post">
    <div class="form-group">
      <textarea type="text" name="notification" id="editor" class="form-control form-control-sm" required><?php echo webdata('notification');?></textarea>
    </div>
	
    <button type="submit" name="notification_update" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Update</button>
    
</form> 	
<script>
    CKEDITOR.replace( 'editor' );
</script>				
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