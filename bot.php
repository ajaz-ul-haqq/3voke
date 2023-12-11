<?php

const PATH = "https://api.telegram.org/bot6969159873:AAGddAnLnHbwK8KGTPExeSGvVxME12pf7R4";
$ask = file_get_contents("php://input");
$update = json_decode($ask, TRUE);

$fp = fopen('data.log', 'a+');
fwrite($fp, $ask);
fclose($fp);

define('CHAT_ID', $update["message"]["chat"]["id"]);

$message = $update["message"]["text"];
$user = $update["message"]["from"];
try {

    require_once 'autoload.php';

    if (strpos($message, "/init") === 0 || strpos($message, "/start") === 0) {
        $response = 'Welcome to the party';
    } elseif (strpos($message, "/voucher") === 0) {
        $input = explode(' ', $message);
        if (count($input)!=2 ) {
            $response = 'please type as /voucher amount';
        }else {
            sendResponse('Creating a voucher of '.$input[1].'.... Please wait !!');
            $url = '<a href="upi://pay?pa=9055713253@upik&pn=AjazUlHaq&cu=INR&amount='.$input[1];

            $voucher = \App\AdminApiHandler::generateVoucher();

            model('vouchers')->insert([
                'value' => $voucher,
                'amount' => $input[1],
                'active' => 1,
                'created_by' => 0,
            ]);

            sendResponse('Boom!!... Voucher of '.$input[1].' is below : ',2);
            $response = $voucher;
        }
    } elseif (strpos($message, "/request") === 0){
        $response = 'This command is under construction';
        $response = urlencode($ask);
    }elseif (strpos($message, "/whoami") === 0){
        $response = 'You are '.$user['first_name'].' '.($user['last_name'] ?? '');
    }elseif (strpos($message, "/enablesafemode") === 0){
        model('strategies')->where('uid', 'no_loss_strategy')->update(['active' => 1]);
        $response ='Activated No Loss Strategy';
    }elseif (strpos($message, "/disablesafemode") === 0){
        model('strategies')->where('uid', 'no_loss_strategy')->update(['active' => 0]);
        $response ='Deactivated No Loss Strategy';
    }elseif (strpos($message, "/currentgame") === 0){
        $response = 'Ongoing Game ID is : '.currentGameId();
    }
    else {
        $response = 'Invalid Command';
    }
} catch (\Exception $exception) {
    sendResponse('Oops!!.. Exception : '.$exception->getMessage());
}

sendResponse($response ?? 'kkkkkkkk');

function sendResponse($response, int $after = 0): void
{
    sleep($after);
    file_get_contents(PATH."/sendmessage?chat_id=".CHAT_ID.'&text='.$response);
}

?>