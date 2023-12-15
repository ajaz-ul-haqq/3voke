<?php
session_start();
session_regenerate_id();
require_once('../system/function.php');	
if($_SERVER["REQUEST_METHOD"]=="POST"){
$arr = array("status"=>'PENDING', "message"=>'Payment Processing');	
if(isset($_SESSION['txn_ref_id']) && 
!empty($_SESSION['upi_id']) && 
!empty($_SESSION['client_orderid']) && 
!empty($_SESSION['muid']) && 
!empty($_SESSION['auth_token'])){
	
$txn_ref_id = $_SESSION['txn_ref_id'];
$upi_id = $_SESSION['upi_id'];	
$client_orderid = $_SESSION['client_orderid'];	
$muid = $_SESSION['muid'];	
$auth_token = $_SESSION['auth_token'];	

$uquery = sql_query("SELECT * FROM `tb_partner` WHERE id='".$muid."' AND token='".$auth_token."' ");
$userdata = sql_fetch_array($uquery);

$res = sql_query("SELECT * FROM `tb_virtualtxn` WHERE bene_account_ifsc='".$txn_ref_id."' AND bene_account_no='".$upi_id."' ");
$txn_data = sql_fetch_array($res);
if(sql_num_rows($res)==1 && $userdata['id']>0){
$query = sql_query("SELECT * FROM `tb_transactions` WHERE client_orderid='".$client_orderid."' ");
if(sql_num_rows($query)==0){
	
$order_id = GenRandomString();
$client_orderid = $client_orderid;		
$pay_upi = $txn_data['rmtr_account_no'];
$txn_time = $txn_data['txn_time'];
$mode = $txn_data['payment_type'];
$upi_id = $txn_data['bene_account_no'];
$newrrn = $txn_data['bank_ref_num'];
$txn_amount = $txn_data['amount'];	
$settle_amount = $txn_data['settled_amount'];
$txn_type = 'CREDIT';
$remark = $txn_data['rmtr_to_bene_note'];

$plan_slab = sql_fetch_array(sql_query("SELECT * FROM `tb_slab` WHERE id='".$userdata['slab']."' "));


$percentToGet = 100-$plan_slab['upi'];
$percentInDecimal = $percentToGet / 100;
$settle_amount = $percentInDecimal * $txn_amount;

$fees = $txn_amount - $settle_amount;

$closing_balance = $userdata['balance'] + $settle_amount;	
	

$result = sql_query("INSERT INTO `tb_transactions`(`token`, `user_uid`, `order_id`,  `client_orderid`, `date`, `time`, `type`, `mode`, `pay_upi`, `upi_id`, `rrn`, `txn_amount`, `fees`, `settle_amount`, `closing_balance`, `txn_type`, `remark`, `status`) 
VALUES ('".$userdata['token']."','".$userdata['id']."','$order_id','$client_orderid','".date_time("Y-m-d")."','".date_time("h:i:s A")."','Received - $mode','$mode','$pay_upi','$upi_id','$newrrn','$txn_amount','$fees','$settle_amount','$closing_balance','$txn_type','$remark','COMPLETED')");

if($result){
if(sql_query("UPDATE `tb_partner` SET balance='".$closing_balance."' WHERE id='".$userdata['id']."' ")){

$json_string = json_encode(array(
"txnStatus"=>'TXN_SUCCESS', 
"resultInfo"=>'Transactions Success',
"orderId"=>$client_orderid,
"txnAmount"=>$txn_amount,
"txnId"=>$order_id,
"bankTxnId"=>$newrrn,
"paymentMode"=>$mode,
"txnDate"=>$txn_time,
"utr"=>$newrrn,
"sender_vpa"=>$pay_upi,
"sender_note"=>$remark,
"payee_vpa"=>$upi_id,
));	

$hash = hash_encrypt($json_string, $userdata['secret']);
require_once('../system/checksum.php');
$RechPayChecksum = RechPayChecksum::generateSignature($json_string,$userdata['secret']);
$arr = array("status"=>'SUCCESS', "message"=>'Transactions Successfully', "hash"=>$hash, "checksum"=>$RechPayChecksum);	
//session_destroy();	
unset($_SESSION['muid']);
unset($_SESSION['auth_token']);
unset($_SESSION['txn_ref_id']);
unset($_SESSION['upi_id']);
unset($_SESSION['client_orderid']);	
}else{
$arr = array("status"=>'FAILED', "message"=>'Gateway Server is Down');	
}


}else{
$arr = array("status"=>'FAILED', "message"=>'Bank Server is Down');	
}	
	
}else{
$arr = array("status"=>'FAILED', "message"=>'Duplicate Order Id');	
}
}
}

}else{
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Request');		
}
echo json_encode($arr);
?>