<?php
header('Content-Type: application/json');
require_once('../system/function.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
if(isset($_POST['token'])&& 
!empty($_POST['bank_ref_num'])){

$token = strip_tags($_POST['token']);
$bank_ref_num = safe_str($_POST['bank_ref_num']);

$res = sql_query("SELECT * FROM `tb_partner` WHERE token='".$token."' AND status='active' ");
$uresult = sql_fetch_array($res);
if(sql_num_rows($res)>0 && $uresult['token']==$token){

$txn_query = sql_query("SELECT * FROM `tb_virtualtxn` WHERE bank_ref_num='".$bank_ref_num."' AND user_id='".$uresult['id']."' ");
$result = sql_fetch_array($txn_query);


$up_res = 0;
if($result['client_orderid']!=""){
    
$client_orderid = time() + rand(00,11);    
$up_res = sql_query("UPDATE `tb_virtualtxn` SET client_orderid='".$result['client_orderid']."' WHERE id='".$result['id']."' AND user_id='".$uresult['id']."' ");

$txn_query = sql_query("SELECT * FROM `tb_virtualtxn` WHERE id='".$result['id']."' AND user_id='".$uresult['id']."' ");
$result = sql_fetch_array($txn_query);

}



if(sql_num_rows($txn_query)>0 && $up_res>0){
	
$json_string = array(
"txnStatus"=>'COMPLETED', 
"resultInfo"=>'Transactions Success',
"orderId"=>$result['client_orderid'],
"txnAmount"=>$result['amount'],
"fees"=>0,
"settle_amount"=>$result['amount'],
"txnId"=>$result['txn_id'],
"bankTxnId"=>$result['bank_ref_num'],
"paymentMode"=>$result['payment_type'],
"txnDate"=>$result['credited_at'],
"utr"=>$result['bank_ref_num'],
"sender_vpa"=>$result['bene_account_no'],
"sender_note"=>$result['rmtr_to_bene_note'],
"payee_vpa"=>$result['rmtr_account_no'],
);		
	
$arr = array("status"=>'SUCCESS', "message"=>'Transactions Successfully', "result"=>$json_string);		

}else{	
$arr = array("status"=>'FAILED', "message"=>'This UTR ('.$bank_ref_num.'), is Not Available');
}



}else{	
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Access or Token Is Invalid');
}

	
}else{
$arr = array("status"=>'FAILED', "message"=>'Parameter Missing');
}

}else{
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Request');
}

echo json_encode($arr);
?>
