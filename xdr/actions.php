<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once '../autoload.php';

$request = (new \App\Request)->intercept();

$action = $_GET['action'] ?? '';

match ($action) {
    'customizeNumber' => \App\AdminApiHandler::customizeNumber($request),
    'customizeStrategy' => \App\AdminApiHandler::customizeStrategy($request),
    'getROIs' => \App\AdminApiHandler::getInvestments($request),
    'generateVoucher' => \App\AdminApiHandler::createVoucher($request->get('amount')),
    'approveWithdrawal' => \App\AdminApiHandler::approveWithdrawal($request),
    'declineWithdrawal' => \App\AdminApiHandler::approveWithdrawal($request, 'REJECTED'),
    'completeWithdrawal' => \App\AdminApiHandler::approveWithdrawal($request, 'COMPLETED'),
    default => \App\ApiHandler::errorResponse('Invalid Action')
};


