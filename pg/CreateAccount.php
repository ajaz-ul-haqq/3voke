<?php
require_once('system/function.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo webdata('company_name');?> | Create Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="assets/dist/css/adminx.css" media="screen" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
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
  background:#0857ab;
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

<div class="p-4">
<div class="container">	
<div class="row justify-content-center">
<?php
if(isset($_GET['paystatus'])){
if($_GET['paystatus']=='success'){
    echo '<script>swal("Registered Mobile Number!", "Login Credentials Has Been Sent Successfully!✅", "success");</script>';
}else{
    echo '<script>swal("Alert!", "Payment failed!", "error");</script>';
    redirect('https://pbsmm.store/CreateAccount','1500');
} }
if(isset($_POST['create_account']) && 
!empty($_POST['pan_no']) &&  
!empty($_POST['name']) &&  
!empty($_POST['company_name']) &&  
!empty($_POST['uid_no']) &&  
!empty($_POST['email']) &&  
!empty($_POST['mobile']) ){
    
    // get payment data from db

     $activeKeyData = ['key'=>'3ce20f-062089-3a3b4b-577799-134eac','secret'=>'OohbD3CGZJ','upiuid'=>'paytmqr281005050101ycbjjlfuek32@paytm'];
		$keyId = $activeKeyData['key'];
		$keySecret = $activeKeyData['secret'];
		$upiuid = $activeKeyData['upiuid'];
		$request_id = uniqid().uniqid();
		$callback_url = "https://pbsmm.store/newUserPayment";
		
		$amount = 500;

        $client_name = strip_tags($_POST['name']);
		$client_email = strip_tags($_POST['email']);
		$client_mobile = safe_str($_POST['mobile']);

        $paramList["upiuid"] = $upiuid;
        $paramList["token"] = $keyId;
        $paramList["orderId"] = $request_id;
        $paramList["txnAmount"] = $amount;
        $paramList["txnNote"] = "Payment received from ".$client_name;
        $paramList["cust_Mobile"] = $client_mobile;
        $paramList["cust_Email"] = $client_email;
        //$paramList["cust_Id"] = $loggedAccountID;
        $paramList["callback_url"] = $callback_url;
        require_once('system/checksum.php');
        $checkSum = RechPayChecksum::generateSignature($paramList,$keySecret);
        $paramList['checksum']=$checkSum;
        
        if(isset($paramList['checksum'])){
            $_POST['payid']=$request_id;
            $signup =  userSignup($_POST);
            
            if($signup['status']=="su"){
                echo '<html>
                <head>
                <title>Gateway Check Out Page</title>
                </head>
                <body>
                	<center><h1>Please do not refresh this page...</h1></center>
                		<form method="post" action="https://pbsmm.store/order/paytm" name="f1">
                		<table border="1">
                			<tbody>';
                			foreach($paramList as $name => $value) {
                				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
                			}
                echo '</tbody>
                    </table>
                		<script type="text/javascript">
                			 document.f1.submit();
                		</script>
                	</form>
                </body>
                </html>';
            //echo '<script>swal("Registered Mobile Number!", "Login Credentials Has Been Sent Successfully!", "success");</script>';
            }elseif($signup['status']=='ae'){
                echo '<script>setTimeout(function(){ swal("Alert!", "Data Already Exist!", "error"); }, 200);</script>';
                redirect('','2000');
            }else{
                echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
               redirect('','1500');
            }
        }else{
            echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
            redirect('','1500');
        }
  
}

function userSignup($data){
$pan_no = safe_str($data['pan_no']);
$name = strip_tags($data['name']);
$company_name = strip_tags($data['company_name']);
$uid_no = safe_str($data['uid_no']);
$email = strip_tags($data['email']);
$mobile = safe_str($data['mobile']);
$payid = $data['payid'];

$res = sql_query("SELECT * FROM `tb_partner` WHERE pan_no='".$pan_no."' || uid_no='".$uid_no."' || email='".$email."' || mobile='".$mobile."' ");
if(sql_num_rows($res)==''){
$rand = GenRandomString(3).time();  
$pwd = pwd_hash($rand);
$query = sql_query("INSERT INTO tb_partner (`login_id`, `login_pwd`, `name`, `company_name`, `mobile`, `email`, `pan_no`, `uid_no`, `status`, `payid`, `password_bckup`) 
VALUES ('".$pan_no."','".$pwd."','".$name."','".$company_name."','".$mobile."','".$email."','".$pan_no."','".$uid_no."','inactive','".$payid."','".$rand."')");
if($query){
     return ['status'=>'su'];

}else{
    return ['status'=>'er'];
}



}else{
    return ['status'=>'ae'];
}	
	
}
?>
<div class="col-md-6 card  card-nblue p-4 mb-5">	
<h4 class="text-white text-center">📢Create Account</h4>
  <form action="" method="post">
    <div class="form-group">
      <label class="text-white">♻️PAN Number</label>
      <input type="text" class="form-control form-control-sm" id="pan_no" minlength="12" maxlength="10"  name="pan_no" onchange="panValidation(this.value)" placeholder="PAN Number" required>
    </div>
    <div class="form-group">
      <label class="text-white">📮Name as per PAN</label>
      <input type="text" class="form-control form-control-sm" maxlength="50" name="name" placeholder="Name as per PAN" required>
    </div>
    <div class="form-group">
      <label class="text-white">🛒Bussiness Name</label>
      <input type="text" class="form-control form-control-sm" maxlength="50" name="company_name" placeholder="Bussiness Name" required>
    </div>
    <div class="form-group">
      <label class="text-white">⚡Aadhaar Number</label>
      <input type="text" class="form-control form-control-sm" placeholder="Aadhaar Number" name="uid_no" minlength="12" maxlength="12" onkeypress="return isNumber(event)" required>
    </div>
    <div class="form-group">
      <label class="text-white">📒Email Address</label>
      <input type="email" class="form-control form-control-sm" placeholder="Email Address" name="email" maxlength="50" required>
    </div>
    <div class="form-group">
      <label class="text-white">📲Mobile Number</label>
      <input type="text" class="form-control form-control-sm" placeholder="Mobile Number" name="mobile" minlength="10" maxlength="10" onkeypress="return isNumber(event)" required>
    </div>
	<div class="form-check mb-2">
    <input type="checkbox" class="form-check-input" required>
    <label class="form-check-label text-white">I accept the <a href="TermsConditions">Terms & Conditions</a></label>
    </div>
    <button type="submit" name="create_account" class="btn bg-white text-dark btn-sm"><i class="fa fa-check-circle"></i> Proceed</button>
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
	 