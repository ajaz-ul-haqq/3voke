<?php

require_once '../../autoload.php';
require_once('../system/function.php');

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST['token'])&&
        !empty($_POST['orderId'])){

        $token = strip_tags($_POST['token']);
        $orderId = safe_str($_POST['orderId']);

        $result = model('tb_partner')->where('token', $token)->where('status', 'active')->get();

        if (!empty($result)) {
            $txn = model('tb_transactions')->where('client_orderid', $orderId)->where('user_uid', $result['uid'])->get();

            if (!empty($txn)) {
                $json_string = [
                    "txnStatus"=>$result['status'],
                    "resultInfo"=>$result['remark'],
                    "orderId"=>$result['client_orderid'],
                    "txnAmount"=>$result['txn_amount'],
                    "fees"=>$result['fees'],
                    "settle_amount"=>$result['settle_amount'],
                    "txnId"=>$result['order_id'],
                    "bankTxnId"=>$result['rrn'],
                    "paymentMode"=>$result['mode'],
                    "txnDate"=>$result['date'].' '.$result['time'],
                    "utr"=>$result['rrn'],
                    "sender_vpa"=>$result['pay_upi'],
                    "sender_note"=>$result['remark'],
                    "payee_vpa"=>$result['upi_id'],
                ];
                $arr = array("status"=>'SUCCESS', "message"=>'Transactions Successfully', "result"=>$json_string);

            } else{
                $arr = array("status"=>'FAILED', "message"=>'This Order Id is Not Available');
            }
        } else{
            $arr = array("status"=>'FAILED', "message"=>'Unauthorized Access or Token Is Invalid');
        }
    }else{
        $arr = array("status"=>'FAILED', "message"=>'Parameter Missing');
    }

}else{
    $arr = array("status"=>'FAILED', "message"=>'Unauthorized Request');
}


header('Content-Type: application/json');
echo json_encode($arr);

?>
