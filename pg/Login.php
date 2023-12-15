<?php
session_start();
session_regenerate_id();
require_once('system/function.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo webdata('company_name');?> | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="assets/dist/css/adminx.css" media="screen" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/> 
	<link rel="icon" href="<?php echo webdata('web_fav');?>" type="image/*" />
	<script src="assets/dist/js/historry.js"></script>
	<script src="assets/dist/js/sweetalert.min.js"></script>
<style>
.navbar-brand-image {
    width: 3.875rem;
    height: 1.875rem;
}    
.brand-logo{
   background-image: url('images/brand.png');
   background-size: contain; 
   background-repeat: no-repeat;
   background-position: 
   center;
   height: 40px; width: 120px 
    
}

.small-logo {
    /* height: 60px; */
    width: 150px;
}

.adminx-container .navbar {
    font-size: .875rem;
    /* background-color: #000; */
    height: 3.5rem;
    padding: 0;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    background-image: linear-gradient(90deg, #085bac, #11c4cb);
}
.adminx-sidebar {
    /* background: #fff; */
    position: fixed;
    width: 260px;
    top: 3.5rem;
    bottom: 0;
    left: 0;
    z-index: 1040;
    -webkit-box-shadow: 1px 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 1px 1px 1px 0 rgba(0,0,0,.1);
    background-image: linear-gradient(180deg, #095fae, #11c4cb);
}
.sidebar-nav-link {
    padding: .5rem 1.5rem;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    color: #ffffff;
}
.sidebar-nav-link.active {
    color: #ffffff;
}
.sidebar-sub-nav {
    list-style-type: none;
    margin: 0;
    padding: .5rem 0;
    font-size: .875rem;
    background-image: linear-gradient(180deg, #095fae, #11c4cb);
}
a:hover {
  color: white;
}
.card{
border-radius: 5px;	
}
.sp-background {
  background: linear-gradient(#FF9800 , #11c9cc);
  background-size: cover;
}
.card-nblue {
 background: #011f3f;	
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #0e98be;
}

.bg-mix{
  background: linear-gradient(#0857ab,#11c9cc);	
}
.table-hover tbody tr:hover {
    background-color: #011f3f;
    color: white;
}
</style>

  </head>
<body class="sp-background">
<?php
if(isset($_POST['login']) && !empty($_POST['login_id']) && !empty($_POST['login_pwd']) ){

$login_id = safe_str($_POST['login_id']);
$login_pwd = safe_str($_POST['login_pwd']);
$login_otp = safe_str($_POST['login_otp']);

$res = sql_query("SELECT * FROM `tb_partner` WHERE login_id='".$login_id."' AND login_otp='".$login_otp."' AND status='active' ");
$result = sql_fetch_array($res);
$pwd = $result['login_pwd'];
if(sql_num_rows($res)>0 && pwd_verify($login_pwd,$pwd) && $result['status']=="active" && $result['login_otp']==$login_otp){
$rand = GenRandomString(8);    
sql_query("UPDATE `tb_partner` SET login_otp='".$rand."' WHERE id='".$result['id']."' ");
$_SESSION['is_login'] = 'YES';	
$_SESSION['uid'] = $result['id'];	
$_SESSION['is_otp'] = $rand;

echo '<script>swal("Successfully!", "Login your Account!", "success");</script>';	
redirect('Dashboard','1500');
}else{
echo '<script>swal("Alert!", "Credentials is invalid!", "error");</script>';
redirect('','1500');
}	
	
}
?>

<?php
if(isset($_POST['pwd_reset']) && !empty($_POST['login_id']) ){

$login_id = safe_str($_POST['login_id']);

$res = sql_query("SELECT * FROM `tb_partner` WHERE login_id='".$login_id."' AND status='active' ");
$result = sql_fetch_array($res);
$pwd = $result['login_pwd'];
if(sql_num_rows($res)>0 && $result['status']=="active"){
$rand = GenRandomString(3).time();    
$pwd = pwd_hash($rand);
if(sql_query("UPDATE `tb_partner` SET login_pwd='".$pwd."' WHERE id='".$result['id']."' ")){
$msg = "♻️Payment Gateway New Login Pwd is〽️: $rand, never share with anyone. ".webdata('socket').base_url();




$sms_status = SendSMS($result['mobile'],$msg);  


$email_message = "<html><head><title>Payment Gateway New Login Pwd is: $rand, never share with anyone.</title></head><body style='font-family: Arial, Helvetica, sans-serif;'>
    <table style='border:1px solid #ccc;border-radius:8px;' cellpadding='8'>
    <tr><td><img src='" .webdata("company_logo"). "' width='100' style='background: linear-gradient(#0857ab,#11c9cc); border-radius: 10px; padding: 5px;'/></td></tr>
    <tr><td style>Greetings " . $result['name'] . "</td></tr>
    <tr><td>📥Your Username: <b>$login_id</b></td></tr>
    <tr><td>🔏Your Password: <b>$rand</b></td></tr>
  
    <tr><td>We are sharing a Password to access your account.(<b style='color:red;'>never share with anyone.</b>)</td></tr>
    <tr><td>Thank you</td></tr>
    <tr><td>Admin - " . webdata('company_name') . "</td></tr>
    <tr><td>Email: " . support('email') . "</td></tr>
    <tr><td>Phone: " . support('mobile') . "</td></tr></table></body></html>";
    
$mail_status = SendMail($result['email'], " ".webdata('company_name')." ($rand) is your Password for secure access", $email_message);

echo '<script>swal("Registered Mobile Number!", "New Password Has Been Sent Successfully!✅", "success");</script>';
//redirect('','2000');
}else{
echo '<script>swal("Alert!", "Server is Down!", "error");</script>';
redirect('','2000');
}

}else{
echo '<script>swal("Alert!", "Credentials is invalid!", "error");</script>';
redirect('','2000');
}	
	
}




?>
<div class="adminx-container">
<div class="container p-4">	
<div class="row justify-content-center">
<div class="col-md-5 card  card-nblue p-4">	
<h4 class="text-white text-center">📢Login</h4>
  <form action="Login" method="post">
    <div class="form-group">
      <label class="text-white">🏷Username</label>
      <input type="text" class="form-control lid form-control-sm" placeholder="Enter Username" name="login_id" required>
    </div>
    <div class="form-group">
      <label class="text-white">🔐Password</label>
      <input type="password" class="form-control lpwd form-control-sm" placeholder="Enter Password" name="login_pwd">
    </div>
    
<div class="form-group">    
<label class="text-white">🎯OTP Code</label>
<div class="input-group input-group-sm mb-3">
   <input type="password" class="form-control form-control-sm" placeholder="Enter OTP Code" maxlength="8" name="login_otp"> 
  <div class="input-group-append" id="load">
    <button type="button" class="btn btn-primary btn-sm" onclick="SendOtpCode();">🎯Send OTP Code</button>
  </div>
</div>
</div>

	<div class="form-check mb-2">
    <input type="checkbox" class="form-check-input" required>
    <label class="form-check-label text-white">I Accept</label>
    </div>
    <button type="submit" name="login" class="btn bg-white text-dark btn-sm mb-2 mr-2"><i class="fa fa-sign-in"></i> Login Now</button>
    <button type="submit" name="pwd_reset" class="btn bg-white text-dark btn-sm mb-2 mr-2"><i class="fa fa-key"></i> Forgot Password?</button>
    <a href="CreateAccount" class="btn bg-white text-dark btn-sm mb-2 mr-2"><i class="fa fa-user"></i> Create Account</a>
  </form>
</div>

</div>
</div>
</div>

    <!-- If you prefer jQuery these are the required scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="assets/dist/js/vendor.js"></script>
    <script src="assets/dist/js/adminx.js"></script>
	<script src="assets/dist/js/custom-new.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
  </body>
</html> 
	 