<?php
error_reporting(0);
require_once('dbconfig.php');
// Create connection
$conn= mysqli_connect($servername,$username,$password,$dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$hypto_url = "https://partners.hypto.in";
$smsapi_url = "http://88.99.209.80";
?>