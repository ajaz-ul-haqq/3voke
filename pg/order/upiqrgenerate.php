<?php
header('Content-Type: application/json');
require_once('../system/function.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
if(isset($_POST['token']) && !empty($_POST['secret']) ){

$token = strip_tags($_POST['token']);
$secret = strip_tags($_POST['secret']);
$am = strip_tags($_POST['am']);
$tn = strip_tags($_POST['tn']);


$res = sql_query("SELECT * FROM `tb_partner` WHERE token='".$token."' AND secret='".$secret."' AND status='active' ");
$uresult = sql_fetch_array($res);
if(sql_num_rows($res)>0 && $uresult['token']==$token){

$user_id = $uresult['id'];  

$upi_id = get_upi_id($user_id,"upi_id");
$upi_name = get_upi_id($user_id,"upi_name");
$ifsc = get_upi_id($user_id,"ifsc");
$tx = urlencode("upi://pay?pa={$upi_id}&pn={$upi_name}&cu=INR&tn=$tn&am=$am");
$qrcode = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=$tx&choe=UTF-8&chld=L|0"; 

$results = array(
    "qrcode"=>$qrcode, 
    "upi_id"=>$upi_id,
    "upi_name"=>$upi_name,
    "ifsc"=>$ifsc
    );   

$arr = array("status"=>'SUCCESS', "message"=>'Record Found',"results"=>$results); 

}else{	
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Access or Token Secret Is Invalid',"results"=>null); 
}

	
}else{
$arr = array("status"=>'FAILED', "message"=>'Parameter Missing',"results"=>null); ;
}

}else{
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Request',"results"=>null); 
}

echo json_encode($arr);
?>