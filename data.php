<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'autoload.php';

$games = model('games');

$currentGameId = ( (int) date("Ymd") * 1000 ) + ( (int) date("H") * 20) + ( ( (int) ( date('i')  / 3 ) ) + 1 );
$currentGameId = (int) $currentGameId;


function getNumberToStore($category, $gameId): int
{
    try {
        $manuals = model('manual')->where('status', 1)->where('type', $category)->pluckToArray('number');

        if (!empty($manuals)) {
            return $manuals[rand(0,count($manuals)-1)];
        }

        $strategy = model('strategies')->where('active', 1)->first();

        if (!empty($strategy)) {
            return \App\AdminApiHandler::getOutputNumberForStrategy($strategy['uid'], $category, $gameId);
        }

        return rand(0,9);
    } catch (\Exception $exception){
        return rand(0,9);
    }

}

foreach (['parity', 'sapre', 'bcone', 'emerd'] as $category)
{
    try{
        $startFrom =  (int) (date("Ymd") . '001');
        $exists = model('games')->where('type', $category)->orderBy('id', 'desc')->count();

        $lastGame = $exists ? model('games')->where('type', $category)->orderBy('id', 'desc')->value('id') : $startFrom;

        while ($lastGame  < $currentGameId ) {
            $alreadyPlayed = (bool) (model('games')->where('type', $category)->where('id', $lastGame)->count() > 0);

            if (!$alreadyPlayed) {
                $resultStored = getNumberToStore($category, $lastGame);
                $games->insert([
                    'id' => $lastGame,
                    'number' => $resultStored,
                    'type' => $category,
                ]);

                updateUserOrders($lastGame, $resultStored, $category);

                echo $lastGame.PHP_EOL;
            }

            $lastGame = $lastGame + 1;
        }
    }catch (\Exception $e){
        $fp = fopen('data.log', 'a+');
        fwrite($fp, PHP_EOL.$e->getMessage());
        fclose($fp);
    }

}

model('manual')->where('status', 1)->update(['status' => 0]);

function updateUserOrders($lastGame, $result, $category): void
{
    model('orders')->where('type', $category)->where('game_id', $lastGame)->where('selection', $result)->update(['status' => 4]);

    $color = in_array($result, [0,5]) ? 'violet'  : ((int)$result % 2 === 0 ? 'red' : 'green' );

    if (in_array($result, [0,5] )) {

        if ( $result == 5 ) {
            model('orders')->where('type', $category)->where('game_id', $lastGame)->where('selection', 'green')
                ->where('status', 0)->update(['status' => 3]);
        }

        if ($result == 0) {
            model('orders')->where('type', $category)->where('game_id', $lastGame)->where('selection', 'red')
                ->where('status', 0)->update(['status' => 3]);
        }

        model('orders')->where('type', $category)->where('game_id', $lastGame)->where('selection', 'violet')
            ->where('status', 0)->update(['status' => 3]);
    }

    model('orders')->where('type', $category)->where('game_id', $lastGame)->where('selection', $color)->where('status', 0)->update(['status' => 1]);
    model('orders')->where('type', $category)->where('game_id', $lastGame)->where('status', 0)->update(['status' => 2]);

    updateUserWallets($lastGame, $category);
}

function updateUserWallets(mixed $lastGame, mixed $category): void
{
    $orders = model('orders')->where('game_id', $lastGame)->where('type', $category)->whereIn('status', [1,3,4])->get();

    foreach ($orders as $order) {
        $oldBalance = model()->where('id', $order['user_id'])->value('balance');
        $newBalance = getBalanceToAddByOrderStatus($order, $oldBalance);
        model()->where('id', $order['user_id'])->update(['balance' => ( $newBalance ) ]);
    }


}

function getBalanceToAddByOrderStatus($order, $balance): float|int
{
    $new = match ( (int) $order['status']) {
      1 => ((int) $order['amount']) * 1.9,
      3 => ((int) $order['amount']) * 1.45,
      4 => ((int) $order['amount']) * 8.55,
        default => 0
    };

    return ( $new + $balance );
}

die('done');