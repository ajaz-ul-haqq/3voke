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
<?php if($userdata['paytm_active']>0){ ?> 
<?php
if(isset($_POST['upiupdate']) 
&& !empty($_POST['upi_data']) 
&& !empty($_POST['upi_id']) 
&& !empty($_POST['upi_name']) 
&& !empty($_POST['mid']) 
){

$upi_data = strip_tags($_POST['upi_data']);
$upi_id = strip_tags($_POST['upi_id']);
$upi_name = safe_str($_POST['upi_name']);
$mid = strip_tags($_POST['mid']);
$allow = array("paytm");

if(isUPI($upi_id,$allow)){
$paytm_business = json_encode(array("upi_data"=>json_decode($upi_data,true),"upi_id"=>$upi_id, "upi_name"=>$upi_name, "mid"=>$mid));

if(sql_query("UPDATE `tb_partner` SET paytm_business='".$paytm_business."' WHERE id='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "Paytm Business Details Updated!✅", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}else{
echo '<script>swal("Alert!", "UPI Address is not valid, currently support '.implode(", ",$allow).'", "error");</script>';
redirect('','1500');
}

}

print_r(get_paytm_business($userdata['id'],''));
?>

<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid card-nblue">
                <div class="row p-4">
                <div class="col-md-5 mb-4">
				<h4 class="text-white">🔍Paytm QR Code Settings</h4><hr class="bg-white">
<form action="" method="post">
    
    <div class="form-group">
      <label class="text-white">📲Paytm QR Code</label>
      <input type="file" onchange="QRCodeScan(this,'upi_data','base64_img')" class="form-control form-control-sm">
      <input type="hidden" name="qr_code" id="base64_img">
      <input type="hidden" name="upi_data" id="upi_data">
    </div>
    
    <div class="form-group">
      <label class="text-white">⭕Payments Address</label>
      <input type="text" name="upi_id"  id ="upi_id" value="<?php echo get_paytm_business($userdata['id'],"upi_id");?>" onchange="UPIValid(this.value);"  class="form-control form-control-sm" placeholder="Enter Your UPI Address" required>
    </div>
    
    <div class="form-group">
      <label class="text-white">🎯Payments Name</label>
      <input type="text" name="upi_name" id="upi_name" value="<?php echo get_paytm_business($userdata['id'],"upi_name");?>" class="form-control form-control-sm" placeholder="Enter Display Name" required>
    </div>
    
	<h4 class="text-white">🧪Paytm Business API Details</h4><hr class="bg-white">
	
    <div class="form-group">
      <label class="text-white">📢Merchant ID</label>
      <input type="text" name="mid" value="<?php echo get_paytm_business($userdata['id'],"mid");?>" class="form-control form-control-sm" placeholder="Enter Merchant ID" required>
    </div>
						
	<button type="submit" name="upiupdate" class="btn bg-white text-dark btn-sm mt-1"><i class="fa fa-bolt"></i> Submit</button>
	
	
<script type="text/javascript" src="assets/dist/js/qrcode.js"></script>
<script type="text/javascript">

function encodeImageFileAsURL(element,elm) {
  var file = element.files[0];
  var reader = new FileReader();
  reader.onloadend = function() {
	document.getElementById(elm).value = reader.result; 
  }
  reader.readAsDataURL(file);
}


function QRCodeScan(element,elm,base64_img){
swal("Please wait QR Code is Verifying!🔔", {button: false,});
encodeImageFileAsURL(element,base64_img);

	document.getElementById("upi_id").value = '';
	document.getElementById("upi_name").value = '';
    document.getElementById(elm).innerHTML = ''; 
    
setTimeout(function(){

const qrcode = new QRCode.Decoder();

qrcode
  .scan(document.getElementById(base64_img).value)
  .then(result => {
  
    var url = JSON.parse(JSON.stringify(result.data));
   
	let params = (new URL(url)).searchParams;
	var pa = params.get('pa');
	var pn =  params.get('pn'); 
	var obj = { pa: pa, pn: pn};
    var myJSON = JSON.stringify(obj);
    //console.log(pa+" . "+pn);
    if(pa!=null && pn!=null){
	swal("QR Code Verified", "Successfully!✅", "success")
	document.getElementById("upi_id").value = pa;
	document.getElementById("upi_name").value = pn;
    document.getElementById(elm).value = myJSON; 
    }else{
    swal("QR Code is Invalid", "Not Verified!", "error")  
    }
    
  })
  .catch(error => {
	swal ( "Oops" ,  "Something went wrong!" ,  "error" );
    //console.error(result.data);
  });
  
 }, 1000);

}  

function UPIValid(upi_id) { 
  if(isUPI(upi_id)!=true){
  swal ( "Oops" ,  "UPI Adress is not valid!" ,  "error" );    
  document.getElementById("upi_id").value = ""; 
  }
}


function isUPI(upi) {
    return upi.endsWith('@paytm') || upi.endsWith('@sbi');
}
</script> 

</form> 
				
			  
			   
                </div>	
				
                <div class="col-md-5 mb-4">
				<h4 class="text-white">🖋Follow Simple Step</h4><hr class="bg-white">

<div class="">
    
<a style="text-decoration: none;" href="https://dashboard.paytm.com/" target="_blank"><i class="fa fa-location-arrow fa-sm"></i> <span class="text-white">(1) Paytm Business Login or Create Account</span></a><br>
<a style="text-decoration: none;" href="https://dashboard.paytm.com/next/qr-details" target="_blank"><i class="fa fa-location-arrow fa-sm"></i> <span class="text-white">(2) Go to Accept Payments / My QR Code Option</span></a><br>
<a style="text-decoration: none;" href="https://dashboard.paytm.com/next/qr-details" target="_blank"><i class="fa fa-location-arrow fa-sm"></i> <span class="text-white">(3) Click Download QR code and Save QR Code</span></a><br>
<a style="text-decoration: none;" href="https://dashboard.paytm.com/next/apikeys" target="_blank"><i class="fa fa-location-arrow fa-sm"></i> <span class="text-white">(4) Go to Developer Settings / API Keys Option</span></a><br>
<a style="text-decoration: none;" href="https://dashboard.paytm.com/next/apikeys" target="_blank"><i class="fa fa-location-arrow fa-sm"></i> <span class="text-white">(5) Click Production API Details and find Merchant ID</span></a><br>
<a style="text-decoration: none;" href="https://dashboard.paytm.com/next/apikeys" target="_blank"><i class="fa fa-location-arrow fa-sm"></i> <span class="text-white">(6) Click Profile Option and find Merchant ID</span></a><br><br><br>

<iframe width="300" height="200" src="https://www.youtube.com/embed/TQTjoaT_Gqc?start=132" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			  
			   
</div>					
				
 
                </div>
                
                
              </div>
            </div>

            
            
          </div>
        </div>
<?php }else{ ?>        
<div class="col-md-12 col-lg-12 d-flex mt-4">
<div class="card mb-grid w-100 card-nblue text-center">
<h2 class="mt-3 text-white"><b>Accept Payments Directly to your Bank Account</b></h2>
<h3 class="text-white"><b>At 0% Transaction Fee</b></h3>
<button class="btn btn-success btn-sm text-white" onclick="window.open('https://wa.me/91<?=support('mobile')?>?text=<?=urlencode("I'm interested in your UPI Smart Gateway")?>');">Activate UPI Smart Gateway</button>
<div class="card card-custom p-2"><?=webdata("notification")?></div>
</div>
</div>        
<?php } ?>        
      </div>
<?php
require_once('layouts/footer.php');
?>