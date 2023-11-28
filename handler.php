<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

sleep(1);

require_once 'autoload.php';

$request = (new \App\Request)->intercept();

$action = $_GET['action'] ?? '';

match ($action) {
    'verify_otp' => \App\ApiHandler::verifyOneTimePassword($request),
    'user_registration' => \App\ApiHandler::handleUserRegistration($request),
    'authLogin' => \App\ApiHandler::postAuthLogin($request),
    'authLogout' => \App\ApiHandler::postAuthLogout(),
    'password_recovery' => \App\ApiHandler::recoverAuthPassword($request),
    'change_password' => \App\ApiHandler::changeAuthPassword($request),
    'validate_voucher' => \App\ApiHandler::redeemGiftCard($request),
    'saveSessionForPayment' => \App\ApiHandler::savePaymentSession($request),
    'requestWithdrawl' => \App\ApiHandler::createWithdrawlForUser($request),
    'redeemBonus' => \App\ApiHandler::redeemBonus($request),
    default => \App\ApiHandler::sendOneTimePassword($request)
};


