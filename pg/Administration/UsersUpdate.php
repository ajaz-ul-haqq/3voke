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
if(isset($_GET['update']) && !empty($_GET['uid']) ){
	
$uuid = safe_str($_GET['uid']);
	
$res = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uuid."' ");
$count = sql_num_rows($res);	
if($count>0){
$result = sql_fetch_array($res);
$account = json_decode($result['settle_account']);
}else{
echo '<script>swal("Alert!", "User Not Exist!", "error");</script>';
redirect('Users','1500');
exit();
}	
	
}
?>

<?php
if(isset($_POST['account_update']) && 
!empty($_POST['login_id']) &&  
!empty($_POST['pan_no']) && 
!empty($_POST['name']) &&  
!empty($_POST['company_name']) &&  
!empty($_POST['uid_no']) &&  
!empty($_POST['email']) &&  
!empty($_POST['mobile']) &&  
!empty($_POST['account_no'])&& 
!empty($_POST['beneficiary_name'])&& 
!empty($_POST['ifsc']) && 
!empty($_POST['slab_id']) && 
!empty($_POST['status']) &&
$_POST['paytm_active']!=''
){

$login_id = safe_str($_POST['login_id']);
$pan_no = safe_str($_POST['pan_no']);
$name = strip_tags($_POST['name']);
$company_name = strip_tags($_POST['company_name']);
$uid_no = safe_str($_POST['uid_no']);
$email = strip_tags($_POST['email']);
$mobile = safe_str($_POST['mobile']);
$account_no = safe_str($_POST['account_no']);
$beneficiary_name = safe_str($_POST['beneficiary_name']);
$ifsc = safe_str($_POST['ifsc']);
$slab_id = safe_str($_POST['slab_id']);
$status = safe_str($_POST['status']);
$login_pwd = strip_tags($_POST['login_pwd']);
$paytm_active = strip_tags($_POST['paytm_active']);

$settle_account = json_encode(array("account_no"=>$account_no, "beneficiary_name"=>$beneficiary_name, "ifsc"=>$ifsc));	

$pwd = $result['login_pwd'];

if(!empty($login_pwd)){
$pwd = pwd_hash($login_pwd);    
}

if(sql_query("UPDATE `tb_partner` SET login_id='".$login_id."', login_pwd='".$pwd."', pan_no='".$pan_no."', name='".$name."', company_name='".$company_name."', uid_no='".$uid_no."', email='".$email."', mobile='".$mobile."', settle_account='".$settle_account."', slab='".$slab_id."', paytm_active='".$paytm_active."', status='".$status."' WHERE id='".$result['id']."' ")){
echo '<script>swal("Successfully!", "Profile Updated!", "success");</script>';
redirect('','2000');
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('Users','2000');
}

	
}
?>

<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid card-nblue">
					
					<div class="row p-4">
					<div class="col-md-12">
<form action="" method="post" class="row">					    
    <div class="form-group col-md-4">
      <label class="text-white">Login Id</label>
      <input type="text" class="form-control form-control-sm" name="login_id" value="<?php echo $result['login_id'];?>"  placeholder="Login Id" required>
    </div>
    
     <div class="form-group col-md-4">
      <label class="text-white">PAN Number</label>
      <input type="text" class="form-control form-control-sm" id="pan_no" value="<?php echo $result['pan_no'];?>" minlength="12" maxlength="10"  name="pan_no" onchange="panValidation(this.value)" placeholder="PAN Number" required>
    </div>
    
    <div class="form-group col-md-4">
      <label class="text-white">Name as per PAN</label>
      <input type="text" class="form-control form-control-sm" value="<?php echo $result['name'];?>" maxlength="50" name="name" placeholder="Name as per PAN" required>
    </div>
    <div class="form-group col-md-4">
      <label class="text-white">Bussiness Name</label>
      <input type="text" class="form-control form-control-sm" value="<?php echo $result['company_name'];?>" maxlength="50" name="company_name" placeholder="Bussiness Name" required>
    </div>
    <div class="form-group col-md-4">
      <label class="text-white">Aadhaar Number</label>
      <input type="text" class="form-control form-control-sm" value="<?php echo $result['uid_no'];?>" placeholder="Aadhaar Number" name="uid_no" minlength="12" maxlength="12" onkeypress="return isNumber(event)" required>
    </div>
    <div class="form-group col-md-4">
      <label class="text-white">Email Address</label>
      <input type="email" class="form-control form-control-sm" value="<?php echo $result['email'];?>" placeholder="Email Address" name="email" maxlength="50" required>
    </div>
    <div class="form-group col-md-4">
      <label class="text-white">Mobile Number</label>
      <input type="text" class="form-control form-control-sm" value="<?php echo $result['mobile'];?>" placeholder="Mobile Number" name="mobile" minlength="10" maxlength="10" onkeypress="return isNumber(event)" required>
    </div>
    
    <div class="form-group col-md-4">
      <label class="text-white">Account Number</label>
      <input type="text" name="account_no" value="<?php echo $account->account_no;?>" class="form-control form-control-sm" placeholder="Account Number" maxlength="34" required>
    </div>	
	
    <div class="form-group col-md-4">
      <label class="text-white">Beneficiary Name</label>
      <input type="text" name="beneficiary_name" value="<?php echo $account->beneficiary_name;?>" class="form-control form-control-sm" placeholder="Beneficiary Name" minlength="5" maxlength="35" required>
    </div>
	
    <div class="form-group col-md-3">
      <label class="text-white">IFSC</label>
      <input type="text" name="ifsc" value="<?php echo $account->ifsc;?>" class="form-control form-control-sm" placeholder="IFSC" required>
    </div>
    
     <div class="form-group col-md-2">
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
<script>
document.getElementById("slab_id").value = "<?php echo $result['slab'];?>";
</script>          
    </div>
    
     <div class="form-group col-md-2">
      <label class="text-white">Status</label>
      <select id="idstatus" name="status" class="form-control form-control-sm" required>
          <option value="active">Active</option>
          <option value="inactive">InActive</option>
      </select>
<script>
document.getElementById("idstatus").value = "<?php echo $result['status'];?>";
</script>          
    </div>
    
     <div class="form-group col-md-2">
      <label class="text-white">Paytm QR</label>
      <select id="paytm_active" name="paytm_active" class="form-control form-control-sm" required>
          <option value="1">Active</option>
          <option value="0">InActive</option>
      </select>
<script>
document.getElementById("paytm_active").value = "<?php echo $result['paytm_active'];?>";
</script>          
    </div>    
    
    <div class="form-group col-md-3">
      <label class="text-white">Password</label>
      <input type="text" name="login_pwd" class="form-control form-control-sm" placeholder="Password">
    </div>
    
    <div class="form-group col-md-4">
    <button type="submit" name="account_update" class="btn bg-white text-dark btn-sm"><i class="fa fa-check-circle"></i> Update</button>
    <a href="Users" class="btn bg-white text-dark btn-sm"><i class="fa fa-history"></i> Back</a>
    </div>
  </form>					
					
					
					
					
					
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