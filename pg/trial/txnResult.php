<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('lib/Config_RechPay.php');
require_once('lib/RechPayChecksum.php');


$verifySignature = '';
$array = array();
$paramList = array();

$secret = 'OohbD3CGZJ'; // Your Secret Key.
$status = $_POST['status']; // Payment Status Only, Not Txn Status.
$message = $_POST['message']; // Txn Message.
$cust_Mobile = $_POST['cust_Mobile']; // Customer Mobile Number.
$cust_Email = $_POST['cust_Email']; // Customer Email.
$hash = $_POST['hash']; // Encrypted Hash / Generated Only SUCCESS Status.
$checksum = $_POST['checksum'];  // Checksum verifySignature / Generated Only SUCCESS Status.

// Payment Status.
if ($status == "SUCCESS") {
    $paramList = hash_decrypt($hash, $secret);
    $verifySignature = RechPayChecksum::verifySignature($paramList, $secret, $checksum);

    // Checksum verification.
    if ($verifySignature) {
        $array = json_decode($paramList, true);

        // Define payment details variables
        // Access the payment details variables as needed
        $txnAmount = $array['txnAmount'];
        $orderId = $array['orderId'];
        $paymentMode = $array['paymentMode'];
        $txnId = $array['txnId'];
        $bankTxnId = $array['bankTxnId'];
        $txnDate = $array['txnDate'];
        $utr = $array['utr'];
        // Define other payment details variables as needed

        echo '<div style="max-width: 600px; margin: 0 auto;">';
        echo '<h2 style="font-size: 24px; color: green; margin-bottom: 10px;"><b>Payment Details:</b></h2>';
        echo '<table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">';
        foreach ($array as $key => $value) {
            echo "<tr>";
            echo "<td style='font-size: 18px; padding: 5px; border: 1px solid #ccc;'><b>$key:</b></td>";
            echo "<td style='font-size: 18px; padding: 5px; color: green; border: 1px solid #ccc;'><b>$value</b></td>";
            echo "</tr>";
        }
        echo '</table>';
        echo '<hr style="margin-top: 20px; margin-bottom: 20px;">';
        echo '<h2 style="font-size: 24px; color: green;"><b>Checksum Verified!</b></h2>';
        echo '</div>';

        // Define the message for the invoice details
        $tx = "📝 Invoice Details\n\n";
        $tx .= "💰 Transaction Status: $status\n";
        $tx .= "ℹ️ Result Info: $message\n";
        $tx .= "🆔 Order ID: $orderId\n";
        $tx .= "💲 Transaction Amount: ₹$txnAmount\n";
        $tx .= "🔢 Transaction ID: $txnId\n";
        $tx .= "🏦 Bank Transaction ID: $bankTxnId\n";
        $tx .= "💳 Payment Mode: $paymentMode\n";
        $tx .= "📅 Transaction Date: $txnDate\n";
        $tx .= "🔢 UTR: $utr";

        // Generate SweetAlert success message with the payment amount dynamically
        $successScript = "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/sweetalert.min.js'></script>
            <script>
                swal({
                  title: '💰 Payment Successful',
                  text: 'Your payment of ₹$txnAmount was successful. ✔️\\n\\n$tx',
                  icon: 'success',
                  button: 'OK'
                }).then(function () {
                  // Perform any additional actions here
                  // You can redirect to another page or perform other operations
                  // For example:
                  // window.location.href = 'success.php'; // Replace with the URL of your success page
                });
            </script>";

        // Output the success message
        echo $successScript;
    } else {
        // Payment Response
        echo '<div style="max-width: 600px; margin: 0 auto;">';
        echo '<h2 style="font-size: 24px; color: red; margin-bottom: 10px;"><b>Payment Failed!</b></h2>';
        echo "<p style='font-size: 18px;'><b>Payment Status:</b> $status</p>";
        echo "<p style='font-size: 18px;'><b>Payment Message:</b> $message</p>";
        echo '<hr style="margin-top: 20px; margin-bottom: 20px;">';
        echo '<h2 style="font-size: 24px; color: red;"><b>Checksum Invalid!</b></h2>';
        echo '</div>';

        // Define the message for the invoice details
        $tx = "📝 Invoice Details\n\n";
        $tx .= "💰 Payment Status: $status\n";
        $tx .= "ℹ️ Payment Message: $message\n";
        $tx .= "🆔 Order ID: $orderId\n";
        $tx .= "💲 Transaction Amount: ₹$txnAmount";

        // Generate SweetAlert failure message with the payment amount dynamically
        $failureScript = "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/sweetalert.min.js'></script>
            <script>
                swal({
                  title: '💰 Payment Failed',
                  text: 'Your payment was unsuccessful of ₹$txnAmount. ❌\\n\\n$tx',
                  icon: 'error',
                  button: 'OK'
                }).then(function () {
                  // Perform any additional actions here
                  // You can redirect to another page or perform other operations
                  // For example:
                  // window.location.href = 'failure.php'; // Replace with the URL of your failure page
                });
            </script>";

        // Output the failure message
        echo $failureScript;
    }
} else {
    // Generate SweetAlert failure message for non-SUCCESS status dynamically
    $nonSuccessScript = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/sweetalert.min.js'></script>
        <script>
            swal({
              title: '💰 Payment Failed',
              text: 'Your payment was unsuccessful. ❌',
              icon: 'error',
              button: 'OK'
            }).then(function () {
              // Perform any additional actions here
              // You can redirect to another page or perform other operations
              // For example:
              // window.location.href = 'failure.php'; // Replace with the URL of your failure page
            });
        </script>";

    // Output the non-SUCCESS failure message
    echo $nonSuccessScript;
}


?>
