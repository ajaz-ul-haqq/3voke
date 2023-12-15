<?php
session_start();
session_regenerate_id();
require_once('../system/function.php');	
if($_SERVER["REQUEST_METHOD"]=="POST"){
$arr = array("status"=>'PENDING', "message"=>'Payment Processing');	
if(isset($_REQUEST['upi_txn_id']) && 
!empty($_SESSION['upi_id']) && 
!empty($_SESSION['client_orderid']) && 
!empty($_SESSION['muid']) && 
!empty($_SESSION['auth_token'])){
	
$txn_ref_id = $_REQUEST['upi_txn_id'];
$upi_id = $_SESSION['upi_id'];	
$client_orderid = $_SESSION['client_orderid'];	
$txnNote = $_SESSION['txnNote'];	
$client_txnAmount = $_SESSION['txnAmount'];	
$muid = $_SESSION['muid'];	
$auth_token = $_SESSION['auth_token'];	

$uquery = sql_query("SELECT * FROM `tb_partner` WHERE id='".$muid."' AND token='".$auth_token."' ");
$userdata = sql_fetch_array($uquery);

$res = sql_query("SELECT * FROM `tb_virtualtxn` WHERE bank_ref_num='".$txn_ref_id."' AND user_id='".$userdata['id']."' ");
$txn_data = sql_fetch_array($res);

if(sql_num_rows($res)==1 && $txn_data['client_orderid']==0 && $userdata['id']>0){
$query = sql_query("SELECT * FROM `tb_virtualtxn` WHERE client_orderid='".$client_orderid."' ");
if(sql_num_rows($query)==0){
	
$order_id = GenRandomString();
$client_orderid = $client_orderid;		
$pay_upi = $txn_data['rmtr_account_no'];
$txn_time = $txn_data['txn_time'];
$mode = $txn_data['payment_type'];
$upi_id = $txn_data['bene_account_no'];
$newrrn = $txn_data['bank_ref_num'];
$txn_amount = $txn_data['amount'];	
$remark = $txn_data['rmtr_to_bene_note'];

if($txn_amount==$client_txnAmount){

if(sql_query("UPDATE `tb_virtualtxn` SET client_orderid='".$client_orderid."', rmtr_to_bene_note='".$txnNote."' WHERE bank_ref_num='".$txn_ref_id."' AND user_id='".$userdata['id']."' ")){

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
"sender_note"=>$txnNote,
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
unset($_SESSION['txnAmount']);	

}else{
$arr = array("status"=>'FAILED', "message"=>'Gateway Server is Down');	
}

}else{
$arr = array("status"=>'FAILED', "message"=>'Duplicate Request or txnAmount is invalid');	
}

	
}else{
$arr = array("status"=>'FAILED', "message"=>'Duplicate Order Id');	
}
}else{
$arr = array("status"=>'FAILED', "message"=>'Duplicate Request');	
}
}

}else{
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Request');		
}
echo json_encode($arr);
?>