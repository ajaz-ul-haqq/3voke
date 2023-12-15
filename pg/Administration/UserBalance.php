<?php
session_start();
session_regenerate_id();
require_once('../system/function.php');
$uid = $_SESSION['uid'];
$usql = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uid."' ");
$userdata = sql_fetch_array($usql);
if($userdata['type']!=1){
redirect('Logout','0');	    
}

if(isset($_POST['utb'])){
$usql = sql_query("SELECT sum(balance) FROM `tb_partner` ");
$row = sql_fetch_array($usql);

$balance = $row['sum(balance)'] - $userdata['balance'];

$arr = array("status"=>'SUCCESS', "balance"=>moneyformat($balance));

echo json_encode($arr);
}

if(isset($_POST['hypto'])){

$url = $hypto_url."/api/accounts/balance";	
$header = array("Content-Type: application/json","Authorization: ".webdata('hypto_token')."");
$res  = json_decode(curl_get($url,$header));
$status = $res->success;
$message = $res->message;
$balance = $res->data->balance;
$arr = array("status"=>'SUCCESS', "balance"=>$message);
if($status==true){
$arr = array("status"=>'SUCCESS', "balance"=>moneyformat($balance));    
}


echo json_encode($arr);
}
?>