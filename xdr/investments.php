<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../autoload.php';

// Set the HTTP headers to indicate that you're sending JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numberToSet = $_POST['number'];
    (new \App\Models\Model('manual'))->where('number', $numberToSet)->update(['status' => 1]);
    return http_response_code(200);
}


$type = 'parity';

if (isset($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
}

$gameId = ( (int) date("Ymd") * 1000 ) + ( (int) date("H") * 20) + ( ( (int) ( date('i')  / 3 ) ) + 1 );

$orders = (new \App\Models\Model('orders'))->where('type', $type)->select(['id', 'amount', 'selection'])->get();
$i = 0;

while ($i < 10) {
    $numericalOrders = (new \App\Models\Model('orders'))->where('type', $type)
        ->where('game_id', $gameId)->where('selection', $i)->get();

    $amount = 0;

    foreach ($numericalOrders as $numericalOrder) {
        $amount =  $amount + ($numericalOrder['amount'] * 8.5);
    }

    if ($i == 0) {
        $redOrders = (new \App\Models\Model('orders'))->execute(
            'SELECT * FROM `orders` WHERE `game_id` = '.$gameId.' AND `selection` IN ("red", "violet")'
        );

        foreach ($redOrders as $redOrder) {
            $amount = $amount + ($redOrder['amount'] * 1.45);
        }

        $stats[$i] = ['number' => $i, 'amount' => $amount];
        $i++;
        continue;
    }

    if ($i == 5) {
        $greenOrders = (new \App\Models\Model('orders'))->execute(
            'SELECT * FROM `orders` WHERE `game_id` = '.$gameId.' AND `selection` IN ("green", "violet")'
        );

        foreach ($greenOrders as $greenOrder) {
            $amount = $amount + ($greenOrder['amount'] * 1.45);
        }

        $stats[$i] = ['number' => $i, 'amount' => $amount];
        $i++;
        continue;
    }


    $color = $i % 2 == 0 ? 'red' : 'green';

    $colorBasedOrders = (new \App\Models\Model('orders'))->where('type', $type)
        ->where('game_id', $gameId)->where('selection', $color)->get();

    foreach ($colorBasedOrders as $colorBasedOrder) {
        $amount = $amount + ($colorBasedOrder['amount'] * 1.9);
    }

    $stats[$i] = ['number' => $i, 'amount' => $amount];
    $i++;
}

// Output the JSON response
echo json_encode(['gameId' => $gameId, 'stats' => $stats ?? []]);

return http_response_code(200);
