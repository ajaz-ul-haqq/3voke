<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'autoload.php';
include 'records.php';

// Set the HTTP headers to indicate that you're sending JSON
header('Content-Type: application/json');

$gameId = ( (int) date("Ymd") * 1000 ) + ( (int) date("H") * 20) + ( ( (int) ( date('i')  / 3 ) ) + 1 );

$limit = 10;
$page = 1;

if(!isset($_SESSION['user'])){
    echo json_encode(['message' => 'Unauthorized']);
    exit(http_response_code(401));
}

$userId = $_SESSION['user']['id'];

$category = 'parity';

if (isset($_REQUEST['limit'])) {
    $limit = $_REQUEST['limit'];
}

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

if (isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
}
$orders = (new \App\Models\Model('orders'))->where('user_id', $userId)->where('type', $category)
    ->orderBy('id')->offset($limit * ($page - 1))->take($limit);

if (isset($_REQUEST['getuserOrdersOnly'])){
    echo json_encode(['orders' => appendMyRecordsToResponse($orders, $category)]);
    exit(http_response_code(200));
}

$balance = (new \App\Models\Model('users'))->where('id', $userId)->value('balance');
$total = (new \App\Models\Model('games'))->where('type', 'parity')->count('id');
$baseUrl = 'universal.php?type='.$category.'&';

$categoryData = (new \App\Models\Model('games'))->where('type', $category)
    ->offset($limit * ($page - 1))->orderBy('id','desc')->take($limit);

$games['pagination'] = [
    'next_page_url' =>  ($page * $limit)  > $total ? '': $baseUrl.'limit='.$limit.'&page='.$page + 1,
    'prev_page_url' => $page > 1 ? $baseUrl.'limit='.$limit.'&page='.$page-1 : '',
];

appendCategoryRecordsToResponse($categoryData, $category, $games);


// Output the JSON response
echo json_encode(['gameId' => $gameId, 'balance' =>  number_format($balance), 'types' =>  $games, 'orders' => appendMyRecordsToResponse($orders, $category)]);



/** Datatables functions */

function appendCategoryRecordsToResponse($data, $category, &$games): void
{
    $r = ' <div class="containerrecord text-center"></div><div class="table-container">
        <table class="table table-borderless table-hover text-center"><thead>
        <tr><th>Period</th><th>Number</th><th>Result</th></tr></thead><tbody>';

    foreach ($data as $result) {
        $color = match ((int)$result['number']) {
            5 => '<div class="point" style="background:#1DCC70;"></div> <div class="point" style="background:darkviolet;"></div>',
            0 => '<div class="point" style="background:red;"></div> <div class="point green" style="background:darkviolet;"></div>',
            default => $result['number'] % 2 == 0 ? '<div class="point red" style="background:#ff2d55;"></div>'
                : '<div class="point green" style="background:#1DCC70;"></div>'
        };

        $r = $r . '<tr><td>' . $result['id'] . '</td><td>' . $result['number'] . '</td><td>' . $color . '</td></td></tr>';

    }

    $r = $r. '</tbody></table>';

    $games[$category] = $r;
}

