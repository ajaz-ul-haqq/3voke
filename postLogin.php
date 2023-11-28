<?php

require_once 'autoload.php';


session_start();

if(isset($_SESSION['user'])){
    header('Location:index.php');
}

// Set the HTTP headers to indicate that you're sending JSON
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['message' => 'method not allowed']);
    exit(http_response_code(302));
}

$phone = filter_var($_POST['login_mobile'], FILTER_VALIDATE_INT);
$pass = filter_var($_POST['login_password']);


isValid($phone, $pass, $message);

if (!empty($message)) {
    echo json_encode(['message' => $message]);
    exit(http_response_code(401));
}

$_SESSION['user'] = (new \App\Models\Model('users'))->where('phone', $phone)
    ->select(['id', 'name', 'phone', 'active'])->first();

// Output the JSON response
echo json_encode([ 'message' => 'Logged in successfully', 'data' => $_SESSION['user']]);

exit(http_response_code(200));


function isValid(mixed $phone, mixed $pass, &$message): bool
{
    if (!is_numeric($phone) || strlen($phone) < 10) {
        $message = 'Oops... Invalid Phone number';
        return false;
    }

    $model = new App\Models\Model('users');

    if ( ! $model->where('phone', $phone)->count() ) {
        $message = 'This phone is not registered with us..';
        return false;
    }

    $pwdHash = (new App\Models\Model('users'))
        ->where('phone', $phone)->value('password');

    if ( password_verify($pass, $pwdHash) == 1 ) {
        $message = '';
        return true;
    }

    $message = 'Oops.. Invalid Password';
    return false;
}