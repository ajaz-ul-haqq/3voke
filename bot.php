<?php

$path = "https://api.telegram.org/bot6969159873:AAGddAnLnHbwK8KGTPExeSGvVxME12pf7R4";
$ask = file_get_contents("php://input");
$update = json_decode($ask, TRUE);

$fp = fopen('data.log', 'a+');
fwrite($fp, $ask);
fclose($fp);

$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];


try {
    if (strpos($message, "/init") === 0) {
        $response = 'Welcome to the party';
    } elseif (strpos($message, "/voucher") === 0) {
        $input = explode(' ', $message);
        if (count($input)!=2 ) {
            $response = 'please type as /voucher amount';
        }else {

            require_once 'autoload.php';

            $response = 'oh you need a voucher of '.$input[1];
            $url = '<a href="upi://pay?pa=9055713253@upik&pn=AjazUlHaq&cu=INR&amount='.$input[1];

            $voucher = \App\AdminApiHandler::generateVoucher();

            model('vouchers')->insert([
                'value' => $voucher,
                'amount' => $input[1],
                'active' => 1,
                'created_by' => 0,
            ]);

            $response = 'Boom!!... Voucher of '.$input[1].' is here : '.$voucher;
        }
    }
    else {
        $response = 'Invalid Command';
    }
} catch (\Exception $exception) {
    $response = $exception->getMessage();
}


file_get_contents($path."/sendmessage?chat_id=".$chatId.'&text='.$response);
?>