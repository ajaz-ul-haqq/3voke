<?php
require_once('layouts/header.php');
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
<!-- Modal -->
<div class="modal fade" id="CreateSlab" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-4 card-nblue">
   <form action="" method="post">
   
    <div class="form-group">
      <label class="text-white">Slab Name</label>
      <input type="text" name="name" class="form-control form-control-sm" placeholder="Slab Name" maxlength="40" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">UPI Pricing</label>
      <input type="text" name="upi" class="form-control form-control-sm" placeholder="UPI Pricing" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">VAN Pricing</label>
      <input type="text" name="van" class="form-control form-control-sm" placeholder="VAN Pricing" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">IMPS Payout ₹1 to ₹1000</label>
      <input type="text" name="imps_slab1" class="form-control form-control-sm" placeholder="IMPS Payout ₹1 to ₹1000" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">IMPS Payout ₹1000 to ₹25000</label>
      <input type="text" name="imps_slab2" class="form-control form-control-sm" placeholder="IMPS Payout ₹1000 to ₹25000" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">IMPS Payout ₹25000 to ₹100000</label>
      <input type="text" name="imps_slab3" class="form-control form-control-sm" placeholder="IMPS Payout ₹25000 to ₹100000" required>
    </div>
	
    
	<div class="form-group">
      <label class="text-white">NEFT Payout ₹1 to ₹1000</label>
      <input type="text" name="neft_slab1" class="form-control form-control-sm" placeholder="NEFT Payout ₹1 to ₹1000" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">NEFT Payout ₹1000 to ₹25000</label>
      <input type="text" name="neft_slab2" class="form-control form-control-sm" placeholder="NEFT Payout ₹1000 to ₹25000" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">NEFT Payout ₹25000 to ₹100000</label>
      <input type="text" name="neft_slab3" class="form-control form-control-sm" placeholder="NEFT Payout ₹25000 to ₹100000" required>
    </div>
	
    <button type="submit" name="createslab" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Create Slab</button>
    
  </form>
    </div>
  </div>
</div>
<?php
if(isset($_POST['createslab']) && 
!empty($_POST['name'])&& 
!empty($_POST['upi'])&& 
!empty($_POST['van'])&& 
!empty($_POST['imps_slab1'])&& 
!empty($_POST['imps_slab2'])&& 
!empty($_POST['imps_slab3'])&&  
!empty($_POST['neft_slab1'])&& 
!empty($_POST['neft_slab2'])&& 
!empty($_POST['neft_slab3'])){
	
$name = safe_str($_POST['name']);
$upi = safe_str($_POST['upi']);
$van = safe_str($_POST['van']);
$imps_slab1 = safe_str($_POST['imps_slab1']);
$imps_slab2 = safe_str($_POST['imps_slab2']);
$imps_slab3 = safe_str($_POST['imps_slab3']);
$neft_slab1 = safe_str($_POST['neft_slab1']);
$neft_slab2 = safe_str($_POST['neft_slab2']);
$neft_slab3 = safe_str($_POST['neft_slab3']);

$arr = array("slab1"=>$imps_slab1, "slab2"=>$imps_slab2, "slab3"=>$imps_slab3);
$imps = json_encode($arr);

$arr = array("slab1"=>$neft_slab1, "slab2"=>$neft_slab2, "slab3"=>$neft_slab3);
$neft = json_encode($arr);

$res = sql_query("SELECT * FROM `tb_slab` WHERE name='".$name."' ");
$result = sql_num_rows($res);	
if($result==0){
    
$query = sql_query("INSERT INTO `tb_slab`(`name`, `upi`, `van`, `imps`, `neft`, `uid`, `status`)
VALUES ('$name','$upi','$van','$imps','$neft','".$userdata['id']."','1')");
if($query){
echo '<script>swal("Successfully!", "Slab Has Created!", "success");</script>';
redirect('','1500');	
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}


}else{
echo '<script>swal("Alert!", "Slab Already Exist!", "error");</script>';
redirect('','1500');
}	
	
}
?>


<!-- Modal -->
<div class="modal fade" id="UpdateSlab" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-4 card-nblue">
   <form action="" method="post">
   
    <div class="form-group">
      <label class="text-white">Slab Name</label>
      <input type="hidden" id="id" name="sid">
      <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Slab Name" maxlength="40" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">UPI Pricing</label>
      <input type="text" id="upi" name="upi" class="form-control form-control-sm" placeholder="UPI Pricing" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">VAN Pricing</label>
      <input type="text" id="van"  name="van" class="form-control form-control-sm" placeholder="VAN Pricing" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">IMPS Payout ₹1 to ₹1000</label>
      <input type="text" id="imps_slab1" name="imps_slab1" class="form-control form-control-sm" placeholder="IMPS Payout ₹1 to ₹1000" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">IMPS Payout ₹1000 to ₹25000</label>
      <input type="text" id="imps_slab2"  name="imps_slab2" class="form-control form-control-sm" placeholder="IMPS Payout ₹1000 to ₹25000" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">IMPS Payout ₹25000 to ₹100000</label>
      <input type="text" id="imps_slab3"  name="imps_slab3" class="form-control form-control-sm" placeholder="IMPS Payout ₹25000 to ₹100000" required>
    </div>
	
    
	<div class="form-group">
      <label class="text-white">NEFT Payout ₹1 to ₹1000</label>
      <input type="text" id="neft_slab1" name="neft_slab1" class="form-control form-control-sm" placeholder="NEFT Payout ₹1 to ₹1000" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">NEFT Payout ₹1000 to ₹25000</label>
      <input type="text" id="neft_slab2" name="neft_slab2" class="form-control form-control-sm" placeholder="NEFT Payout ₹1000 to ₹25000" required>
    </div>
    
	<div class="form-group">
      <label class="text-white">NEFT Payout ₹25000 to ₹100000</label>
      <input type="text" id="neft_slab3" name="neft_slab3" class="form-control form-control-sm" placeholder="NEFT Payout ₹25000 to ₹100000" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">Status</label>
      <select id="status" name="status" class="form-control form-control-sm" required>
	   <option value="1">Active</option>
	   <option value="0">InActive</option>
	   
	  </select>
    </div>	
    <button type="submit" name="updatelab" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Update Slab</button>
    
  </form>
    </div>
  </div>
</div>

<?php
if(isset($_POST['updatelab']) && 
!empty($_POST['sid'])&& 
!empty($_POST['name'])&& 
!empty($_POST['upi'])&& 
!empty($_POST['van'])&& 
!empty($_POST['imps_slab1'])&& 
!empty($_POST['imps_slab2'])&& 
!empty($_POST['imps_slab3'])&&  
!empty($_POST['neft_slab1'])&& 
!empty($_POST['neft_slab2'])&& 
!empty($_POST['neft_slab3'])){
    
$sid = safe_str($_POST['sid']);	
$name = safe_str($_POST['name']);
$upi = safe_str($_POST['upi']);
$van = safe_str($_POST['van']);
$imps_slab1 = safe_str($_POST['imps_slab1']);
$imps_slab2 = safe_str($_POST['imps_slab2']);
$imps_slab3 = safe_str($_POST['imps_slab3']);
$neft_slab1 = safe_str($_POST['neft_slab1']);
$neft_slab2 = safe_str($_POST['neft_slab2']);
$neft_slab3 = safe_str($_POST['neft_slab3']);
$status = safe_str($_POST['status']);

$arr = array("slab1"=>$imps_slab1, "slab2"=>$imps_slab2, "slab3"=>$imps_slab3);
$imps = json_encode($arr);

$arr = array("slab1"=>$neft_slab1, "slab2"=>$neft_slab2, "slab3"=>$neft_slab3);
$neft = json_encode($arr);

$res = sql_query("SELECT * FROM `tb_slab` WHERE id='".$sid."' ");
$result = sql_num_rows($res);	
if($result>0){
    
$query = sql_query("UPDATE `tb_slab` SET `name`='$name', `upi`='$upi', `van`='$van', `imps`='$imps', `neft`='$neft', `status`='$status' WHERE id='".$sid."' ");
if($query){
echo '<script>swal("Successfully!", "Slab Updated!", "success");</script>';
redirect('','1500');	
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}


}else{
echo '<script>swal("Alert!", "Slab Not Exist!", "error");</script>';
redirect('','1500');
}	
	
}
?>

<?php
if(isset($_POST['delete']) && !empty($_POST['sid']) ){
	
$uuid = safe_str($_POST['sid']);
	
$res = sql_query("SELECT * FROM `tb_slab` WHERE id='".$uuid."' ");
$result = sql_num_rows($res);	
if($result>0){
$query = sql_query("DELETE FROM `tb_slab` WHERE id='".$uuid."'  ");
if($query){
echo '<script>swal("Successfully!", "Slab Deleted!", "success");</script>';
redirect('','1500');	
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}else{
echo '<script>swal("Alert!", "Slab Not Exist!", "error");</script>';
redirect('','1500');
}	
	
}
?>


<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid">
                  <div class="table-responsive-md">
				  
                    <table class="table table-hover">
				
                      <thead>
                        <tr class="card-nblue">
                          <th class="text-white">Pricing Slab</th>
                          <th class="text-white"  colspan="4">
						  <button class="btn bg-mix text-white btn-sm" data-toggle="modal" data-target="#CreateSlab" type="button">Create Slab <i class="fa fa-plus"></i></button>
						  </th>
						 
<th class="text-white">
<button class="btn bg-mix text-white btn-sm" onclick="Export('Pricing Slab')"  type="button">Export <i class="fa fa-external-link-alt"></i></button>
</th>
						  
                        </tr>
                      </thead>
					
                      <thead>
                        <tr class="bg-mix">
                          <th class="text-white">ID</th>
                          <th class="text-white">NAME</th>
                          <th class="text-white">IMPS</th>
                          <th class="text-white">NEFT</th>
                          <th class="text-white">STATUS</th>
                          <th class="text-white">ACTION</th>
						  
                        </tr>
                      </thead>
                      <tbody>
<?php
$sql = "SELECT * FROM `tb_slab` ORDER BY `id` DESC ";	
$query  = sql_query($sql);
$sl = 1;
while($rows = sql_fetch_array($query)){ 
$status = '<span class="badge badge-danger">InActive</span>';    
if($rows['status']==1){
$status = '<span class="badge badge-success">Active</span>';
}   

$imps = json_decode($rows['imps'],true);
$neft = json_decode($rows['neft'],true);

$arr = array(
"id"=>$rows['id'],
"name"=>$rows['name'], 
"upi"=>$rows['upi'], 
"van"=>$rows['van'], 
"status"=>$rows['status'], 
"imps"=>$imps, 
"neft"=>$neft);

$slab_json = json_encode($arr);
?>						  
						<tr>
                          <td><?php echo $sl;?></td>
						  <td>Name: <?php echo $rows['name'];?><br>UPI: <?php echo $rows['upi'];?>%<br>VAN: <?php echo $rows['van'];?>%</td>
                          <td><span style="font-size:12px;">₹<?php echo $imps['slab1'];?> - ₹1000<br>₹<?php echo $imps['slab2'];?> - ₹25000<br>₹<?php echo $imps['slab3'];?> - ₹100000</span></td>
                          <td><span style="font-size:12px;">₹<?php echo $neft['slab1'];?> - ₹1000<br>₹<?php echo $neft['slab2'];?> - ₹25000<br>₹<?php echo $neft['slab3'];?> - ₹100000</span></td>
                          <td><?php echo $status;?></td>
                          <td>
<button class="btn bg-mix text-white btn-sm mb-2" data-toggle="modal" data-target="#UpdateSlab" onclick="SlabUpdate('<?php echo base64_encode($slab_json);?>');" type="button">Update <i class="fa fa-bolt"></i></button>
</form>
<form action="" method="post"> 
<input type="hidden" name="sid" value="<?php echo $rows['id'];?>">
<button name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure Delete?')">Delete <i class="fa fa-trash"></i></button>
</form>                          
                          </td>
                        </tr>
<?php
$sl++;}
?>											
						
                      </tbody>
                    </table>
<script>
function SlabUpdate(base64) {
  var decodedString = atob(base64);   
  var obj = JSON.parse(decodedString);
  document.getElementById("id").value = obj.id;
  document.getElementById("name").value = obj.name;
  document.getElementById("upi").value = obj.upi;
  document.getElementById("van").value = obj.van;
  document.getElementById("imps_slab1").value = obj.imps.slab1;
  document.getElementById("imps_slab2").value = obj.imps.slab2;
  document.getElementById("imps_slab3").value = obj.imps.slab3;
  document.getElementById("neft_slab1").value = obj.neft.slab1;
  document.getElementById("neft_slab2").value = obj.neft.slab2;
  document.getElementById("neft_slab3").value = obj.neft.slab3;
  document.getElementById("status").value = obj.status;
}
</script>					
					<div class="row">
					<div class="col-sm-12 col-md-5">
					
					</div>
					</div>
					
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