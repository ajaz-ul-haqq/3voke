<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'autoload.php';
require_once 'helpers.php';
include 'records.php';

// Set the HTTP headers to indicate that you're sending JSON
header('Content-Type: application/json');

function userInActive(mixed $userId): bool
{
    return !(new App\Models\Model('users'))->where('id', $userId)->value('active');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $userId = $_POST['userId'];
    $amount = $_POST['amount'];
    $selection = $_POST['selection'];
    $gameId = currentGameId();

    $user = new App\Models\Model('users');
    $balance = $user->where('id', $userId)->value('balance');

    if (userInActive($userId)) {
        echo json_encode(['message' => 'Some error with your account. please contact support']);
        exit(http_response_code(400));
    }

    if ($amount == 0) {
        echo json_encode(['message' => 'Amount must not be zero']);
        return http_response_code(412);
    }

    if (!enoughBalance($balance, $amount)) {
        echo json_encode(['message' => 'Insufficient Balance']);
        return http_response_code(412);
    }

    if (!enoughTime()){
        echo json_encode(['message' => 'Oops.. you are late..']);
        return http_response_code(412);
    }

    executeOrderNow($gameId, $category, $userId, $selection, $amount, $balance);

    $balance = (new App\Models\Model('users'))->where('id', $userId)->value('balance');

    $orders = $orders = (new \App\Models\Model('orders'))->where('user_id', $userId)->where('type', $category)
        ->orderBy('id')->offset(0)->take(10);

    echo json_encode(['category' => $category,
        'amount' => (int) $amount, 'userId' =>  $userId, 'selection' => $selection,
        'balance' => number_format($balance), 'orders' => appendMyRecordsToResponse($orders, $category)]);
    exit( http_response_code(200));
}

function enoughBalance($balance, $amountSelected): bool
{
    return $amountSelected <= $balance;
}

function enoughTime(): bool
{
    $now = time();
    $countDownDate = $now;
    $distance = 180 - ($countDownDate % 180);

    return $distance > 30;
}

function executeOrderNow($gameId, $category, $userId, $selection, $amount, $balance)
{
    $orders = new App\Models\Model('orders');

    $orders->insert([
       'game_id' => $gameId,
       'selection' => $selection,
        'user_id' => $userId,
        'amount' => $amount,
        'type' => $category,
        'status' => 0,
    ]);

    (new App\Models\Model('users'))->where('id', $userId)->update([
        'balance' => ( $balance - $amount)
    ]);
}
