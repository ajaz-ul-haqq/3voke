<?php

require 'helpers.php';

const APP_URL = 'https://faveo.local/evoke/';
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 9090;
const DB_NAME = 'next';
const GATEWAY_HANDLER = 'https://axom.cloud/order/paytm';

function customAutoloader($className): void
{
    $filePath = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($filePath)) {
        require $filePath;
    }
}

function clickAbleProfile($user, $key = 'phone', $adminView = false): string
{
    $baseUrl = $adminView ? 'admin_info.php?id=' : 'info.php?id=';

    try {
        return '<a href="'.$baseUrl.$user['id'].'"><b>'.$user[$key].'</b></a>';
    } catch (\Exception){
        return 'unknown';
    }
}

spl_autoload_register('customAutoloader');