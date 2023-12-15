<?php
require_once('system/function.php');

// get payment data from db

$activeKeyData = ['key'=>'3ce20f-062089-3a3b4b-577799-134eac','secret'=>'OohbD3CGZJ','upiuid'=>'paytmqr281005050101ycbjjlfuek32@paytm'];
$keyId = $activeKeyData['key'];
$keySecret = $activeKeyData['secret'];

$status = $_POST['status']; // Its Payment Status Only, Not Txn Status.
$message = $_POST['message']; // Txn Message.
$hash = $_POST['hash']; // Encrypted Hash / Generated Only SUCCESS Status.
$checksum = $_POST['checksum'];  // Checksum verifySignature / Generated Only SUCCESS Status.

echo "<h4>Please do not reload, payment is processing.</h4>";

// Payment Status.
if($status=="SUCCESS"){
    $paramList = hash_decrypt($hash,$keySecret);
    require_once('system/checksum.php');
    $verifySignature = RechPayChecksum::verifySignature($paramList, $keySecret, $checksum);
    if($verifySignature){
        $array = json_decode($paramList,true); 
        // print_r($array);
        
        // save payment request data
		$payment_request_id = $array['txnId'];
		$request_id = $array['orderId'];
		$amount = $array['txnAmount'];
		
		$usql = sql_query("SELECT * FROM `tb_partner` WHERE payid='".$request_id."'");
        $user = sql_fetch_array($usql);
		$g = sql_query("UPDATE `tb_partner` SET status='active', upi_active='1', paytm_active='1' WHERE payid='".$request_id."'");

		if($g) sendCred($user);
		return redirect('CreateAccount?paystatus=success','1');
    }
}

redirect('CreateAccount?paystatus=failed','1');



function sendCred($data){
$rand = safe_str($data['password_bckup']);
$pan_no = safe_str($data['pan_no']);
$name = strip_tags($data['name']);
$company_name = strip_tags($data['company_name']);
$uid_no = safe_str($data['uid_no']);
$email = strip_tags($data['email']);
$mobile = safe_str($data['mobile']);
$msg = "Dear $name, Username is:$pan_no, Pwd is:$rand,  Thank you for register, never share with anyone. ".webdata('socket').base_url();
//fancy message 
$msg1 = "
💌 Dear " . $name . ",

✉️ Username: " . $pan_no . "
🔒 Password: " . $rand . "

🙏 Thank you for registering! Please remember to never share your username and password with anyone.

🌐 Visit our website at: " . webdata('socket') . base_url() . "

🌟 Stay safe and enjoy your experience with us! ✨
";


$sms_status = SendSMS($mobile,$msg1);      



$email_message = "<html><head><title>Login Credentials</title></head><body style='font-family: Arial, Helvetica, sans-serif;'>
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



$msg = "Dear $name, Complete Your KYC Verification, Contact your Account Manager:+91 ".support('mobile').", Thank You: ".webdata('socket').base_url();
$thanks_msg = "🙏 Thank you for signing up with us, {$name}! 🎉 We're excited to have you on board. If you have any questions or need assistance, feel free to reach out. Welcome to our community! ✨";

$sms_status = SendSMS($mobile,$thanks_msg);  


$email_message = "<html><head><title>Dear $name, Complete Your KYC Verification,</title></head><body style='font-family: Arial, Helvetica, sans-serif;'>
    <table style='border:1px solid #ccc;border-radius:8px;' cellpadding='8'>
    <tr><td><img src='" .webdata("company_logo"). "' width='100' style='background: linear-gradient(#0857ab,#11c9cc); border-radius: 10px; padding: 5px;'/></td></tr>
    <tr><td style>Dear " . $name . "</td></tr>
    <tr><td style>Greetings from " . webdata('company_name') . "..!!</td></tr>
    <tr><td>Your Account Manager: <b>+91 ".support('mobile')."</b></td></tr>
    <tr><td>Your Username: <b>$pan_no</b></td></tr>
    <tr><td>Your Password: <b>$rand</b></td></tr>
    <tr><td>Registration Form: <b><a href='".webdata('socket').base_url()."/docs/RechPayPaymentGatewayRegistrationForm.pdf'>Download</a></b></td></tr>
  
    <tr><td>I need the following details to submit to our acquiring bank to proceed with this process.</td></tr>
    <tr><td>
    <div>
<div>
<ol>
<li>Contact Person name&nbsp;for&nbsp;CPV&nbsp;(verification):&nbsp;</li>
<li>Contact&nbsp;details&nbsp;(mobile):</li>
<li>Registered company name:</li>
<li>Operating Center's Address &amp; nearby Landmark:&nbsp;</li>
<li>Website URL:&nbsp;</li>
<li>Do you have any mobile app?:</li>
<li>Do you have a signboard at your center in the name of your registered business?</li>
<li>Please provide business setup photos:</li>
<li>Go Live date to start transactions:</li>
<li>Expected transactions volume in&nbsp;the next two months:&nbsp;&nbsp;</li>
<li>Purpose of Payment gateway;</li>
<li>Please explain your Business Model.</li>
<li>Please share personal&nbsp;<span>KYC</span>&nbsp;documents (PAN CArd and Aadhar card)</li>
</ol>
</div>
</div>
<p>Please Feel free to share your queries.&nbsp;</p>
    </td></tr>
    <tr><td><b>With Regards</b></td></tr>
    <tr><td>" . webdata('company_name') . "</td></tr>
    <tr><td>Email: " . support('email') . "</td></tr>
    <tr><td>Phone: +91" . support('mobile') . "</td></tr></table></body></html>";
    
$mail_status = SendMail($email, " ".webdata('company_name')." ($name), CPV Details || Requirements,", $email_message);
   return true;
}