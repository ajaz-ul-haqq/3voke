<?php

use \App\Models\Model;

function initiateSession(): void
{
    session_start();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function redirectTo($path = ''): void
{
    header('Location:'.$path);
}

function redirectIfNotLoggedIn($path = 'login.php'): void
{
    initiateSession();
    if (!isLoggedIn()) { redirectTo(); }
}

function redirectIf($condition, $path): void
{
    if($condition) { redirectTo($path); }
}

function getUserBalance(): int
{
    return (int) model()->where('id', $_SESSION['user']['id'])->value('balance');
}


function getUserBonus()
{
    return number_format(3950524, 2);
}

function getHostLink()
{
    return $_SERVER['HTTP_HOST'];
}

function getLoggedInUser()
{
    return $_SESSION['user'] ?? null;
}


function minimumDeposit(): int
{
    return 200;
    return (int) model('system')->where('config', 'minimum_deposit')->value('value');
}

function minimumWithdrawl(): int
{
    return 1000;
    return (int) \model('system')->where('config', 'minimum_withdrawl')->value('value');
}

function currentGameId() : int
{
    return ( (int) date("Ymd") * 1000 ) + ( (int) date("H") * 20) + ( ( (int) ( date('i')  / 3 ) ) + 1 );
}

function getDepositsForUser($userId, $page, $limit, &$html = ''): void
{
    $offset = $limit * ($page - 1);
    $deposits =  (new Model('deposits'))->where('user_id', $userId)
        ->orderBy('id')
        ->offset($offset)->take($limit);

    foreach ($deposits as $deposit) {
        $date = date('d M, Y h:i A', strtotime($deposit['created_at']));

        $class =  match($deposit['status']) {
            'FAILED' => 'text-danger',
            'SUCCESS' => 'text-success',
            default => 'text-warning'
        };

        $x = "<span class='text ".$class."'><b>".$deposit['status']."</b></span>";

        $html = $html. '<tr><td class="p-1"><div class="listItem"><div class="image"><div class="iconBox bg-success"> <i class="icon ion-md-wallet"></i>
                  </div></div><div class="text"><div><strong><b>'. number_format($deposit['amount'],2).'</b></strong><small>'.$date.'</small></div></div>
                  </div></td><td><b>'.$x.'</b></td></tr>';
    }
}


function getWithdrawalForUsers($userId, $page, $limit, &$html = ''): void
{
    $offset = $limit * ($page - 1);
    $withdrawals = (new Model('withdrawls'))->where('user_id', $userId)
        ->orderBy('id')
        ->offset($offset)->take($limit);

    foreach ($withdrawals as $withdrawal) {
        $date = date('d M, Y h:i A', strtotime($withdrawal['created_at']));

        $class =  match($withdrawal['status']) {
            'APPROVED' => 'text-primary',
            'REJECTED' => 'text-danger',
            'COMPLETED' => 'text-success',
            default => 'text-warning'
        };

        $x = "<span class='text ".$class."'><b>".$withdrawal['status']."</b></span>";

        $html = $html . '<tr><td class="p-1"><div class="listItem"><div class="image"><div class="iconBox bg-danger"> <i class="icon ion-md-exit"></i>
                  </div></div><div class="text"><div><strong><b>'. number_format($withdrawal['amount'], 2).'<b></b></strong><small>' . $date . '</small></div></div>
                  </div></td><td>' . $x . '</td></tr>';
    }
}

function model($table = 'users'): Model
{
    return new Model($table);
}

function generateRandomString($length = 16): string
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

function getUserUniqueId($userid): string
{
    return 'EVX9RD'.(str_pad($userid, 5 - strlen($userid), '0', STR_PAD_LEFT));
}

function enableDebugging(): void
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

function terminateSession(): void
{
    session_abort();
}