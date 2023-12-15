<?php
require_once('layouts/header.php');

$account = json_decode($userdata['settle_account']);
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid card-nblue">
                  
                <div class="row p-4">
                <div class="col-md-12">
                 <h5 class="text-white">📣Gateway Check Out Page - REQUEST FORM DATA POST</h5><hr class="bg-white">
                </div>    
		  
                <div class="col-md-12">
                 <b class="text-white">📲REQUEST PARAMETER - URL : (<?php echo webdata('socket');?><?php echo base_url();?>/order/process) | (<?php echo webdata('socket');?><?php echo base_url();?>/order/payment)</b>
<table class="table text-white mt-1">
  <tr>
    <th>Key</th>
    <th>Value</th>
    <th>Message</th>
  </tr>
  <tr>
    <td>upiuid</td>
    <td>yourupiid@paytm</td>
    <td>Its UPI Unique ID (Url:<?php echo webdata('socket');?><?php echo base_url();?>/PaytmBusiness)</td>
  </tr>
  <tr>
    <td>token</td>
    <td>b3eb29-51c8f0-dacce6-d39ac0-faf954</td>
    <td>Your API Token (Url:<?php echo webdata('socket');?><?php echo base_url();?>/Settings)</td>
  </tr>
  <tr>
    <td>orderId</td>
    <td>ORDS5845584</td>
    <td>Your Unique ID (Only alphanumeric is allowed)</td>
  </tr>
  <tr>
    <td>txnAmount</td>
    <td>100</td>
    <td>Payment Amount (Decimal amount > 0 and less than balance)</td>
  </tr>
  <tr>
    <td>txnNote</td>
    <td>Test</td>
    <td>Your Message (Only alphanumeric and space are allowed. Min characters: 2)</td>
  </tr>
  <tr>
    <td>callback_url</td>
    <td>http://localhost/txnResult</td>
    <td>Your Callback (<?php echo webdata('company_name');?> sends the response of transaction on the URL which comes in the callbackUrl parameter)</td>
  </tr>
  <tr>
    <td>checksum</td>
    <td>ghvsaf764t3w784tbjkegbjhdbgf==</td>
    <td><a href="#" >Checksum Logic</a> (<?php echo webdata('company_name');?> validates the request and ensures that parameters are not tempered by verifying the checksum in the request. )</td>
  </tr>
  <tr>
    <td>Sample</td>
    <td>Download</td>
    <td><a href="../sample.zip">Click here</a> to Download the Sample Code for Payment Form.</td>
  </tr>
</table>
                </div> 
				
                <div class="col-md-12">
                 <h5 class="text-white">Gateway Check Out Page - RESPONSE FORM DATA POST</h5><hr class="bg-white">
                </div>    
		  
                <div class="col-md-12">
                 <b class="text-white">RESPONSE PARAMETER</b>
<table class="table text-white mt-1">
  <tr>
    <th>Key</th>
    <th>Value</th>
    <th>Message</th>
  </tr>
  <tr>
    <td>status</td>
    <td>SUCCESS/FAILED</td>
    <td>Payment Status (Its Payment Status Only, Not Txn Status)</td>
  </tr>
  <tr>
    <td>message</td>
    <td>Txn Success</td>
    <td>Txn Message (Transaction Related Messages)</td>
  </tr>
  <tr>
    <td>hash</td>
    <td>fbgfgevdfdfdfdf==</td>
    <td><a href="#">Decrypt Logic</a> (Encrypted Hash Generated Only SUCCESS Status)</td>
  </tr>
  <tr>
    <td>checksum</td>
    <td>g45fdf64t3w784tbjkegbjhdbgf==	</td>
    <td>Checksum Signature <a href="#" >Checksum Logic</a> (Checksum verifySignature / Generated Only SUCCESS Status)</td>
  </tr>
</table>
                </div> 				
				
 <div class="col-md-12">
                 <h5 class="text-white">Transaction Status - REQUEST FORM DATA POST</h5><hr class="bg-white">
                </div>    
		  
                <div class="col-md-12">
                 <b class="text-white">REQUEST PARAMETER - URL (<?php echo webdata('socket');?><?php echo base_url();?>/order/status)</b>
<table class="table text-white mt-1">
  <tr>
    <th>Key</th>
    <th>Value</th>
    <th>Message</th>
  </tr>
  <tr>
    <td>token</td>
    <td>b3eb29-51c8f0-dacce6-d39ac0-faf954</td>
    <td>Your API Token (Url:<?php echo webdata('socket');?><?php echo base_url();?>/Settings)</td>
  </tr>
  <tr>
    <td>orderId</td>
    <td>ORDS5845584</td>
    <td>Your Unique ID (Only alphanumeric is allowed)</td>
  </tr>
</table>
                </div> 					
				
 <div class="col-md-12">
                 <h5 class="text-white">Transaction Status - RESPONSE JSON DATA</h5><hr class="bg-white">
                </div>    
		  
                <div class="col-md-12">
                 <b class="text-white">RESPONSE PARAMETER</b>
<pre class="text-white mt-1">
{"status":"SUCCESS","message":"Transactions Successfully","result":{"txnStatus":"COMPLETED","resultInfo":"Test","orderId":"ORDS1603859476","txnAmount":"1.0","fees":"0.005","settle_amount":"0.995","txnId":"6NG2A97o7U","bankTxnId":"030210161145","paymentMode":"UPI","txnDate":"2020-10-28 10:01:59 AM","utr":"030210161145","sender_vpa":"UPI@upi","sender_note":"Test","payee_vpa":"UPI"}}
</pre>
                </div> 					
				
                </div>
                
                
                
              </div>
            </div>

            
            
          </div>
        </div>
      </div>
<?php
require_once('layouts/footer.php');
?>