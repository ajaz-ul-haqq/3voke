<?php

require 'helpers.php';
function customAutoloader($className): void
{
    $filePath = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($filePath)) {
        require $filePath;
    }
}

function clickAbleProfile($user, $key = 'phone'): string
{
    try {
        return '<a href="info.php?id='.$user['id'].'"><b>'.$user[$key].'</b></a>';
    } catch (\Exception){
        return 'unknown';
    }
}

spl_autoload_register('customAutoloader');