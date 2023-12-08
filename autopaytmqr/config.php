<?php

error_reporting(0);

$merchant = model('merchant')->first();
$token = $merchant['token'];
$secret = $merchant['secret'];

define("PAYTM_BUSINESS_UPI", $merchant['upi']);