<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'autoload.php';
require_once 'helpers.php';

for($i=0; $i<100; $i++) {
    model('vouchers')->insert([
        'value' => generateRandomString(),
        'amount' => rand(1000, 9999),
        'active' => 1,
    ]);
}

