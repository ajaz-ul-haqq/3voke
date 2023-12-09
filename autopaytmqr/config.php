<?php

error_reporting(0);

$merchants = model('merchant')->where('status', 1)->get();
$merchant = $merchants[rand(0, count($merchants) -1)];

$token = $merchant['token'];
$secret = $merchant['secret'];

define("PAYTM_BUSINESS_UPI", $merchant['upi']);