<?php

$conn = (new \App\Models\BaseModel())->conn;

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

function sql_query($sql){
global $conn;
$result = mysqli_query($conn,$sql);
if($result){
  return $result;
}

}

function sql_fetch_array($data){
$result = mysqli_fetch_array($data);
if($result){
  return $result;
}

}

function sql_num_rows($data){
$result = mysqli_num_rows($data);
if($result){
  return $result;
}

}

function sql_insert_id(){
global $conn;
$result = mysqli_insert_id($conn);
if($result){
  return $result;
}

}

function real_escape_string($str){
global $conn;
return mysqli_real_escape_string($conn,$str);
}


function pwd_hash($password){
return password_hash($password, PASSWORD_DEFAULT);
}

function pwd_verify($password,$hash){
return password_verify($password,$hash);
}

function token_gen($lnt){
return bin2hex(openssl_random_pseudo_bytes($lnt));
}


function misec_datetime($mils,$format){
return $d = date("Y-m-d h:i:s", $mils/1000);
}

function isUPI($upi,$allow) {
    $upi = trim($upi); // in case there's any whitespace
    $arr = explode("@",$upi);

    if(in_array($arr[1],$allow)){
     return true;
    }

}


function get_upi_id($uid,$type){
$usql = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uid."' ");
$row = sql_fetch_array($usql);
$res = json_decode($row['upis'],true);
return $res[$type];
}


function get_paytm_business($uid,$type){
$usql = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uid."' ");
$row = sql_fetch_array($usql);
$res = json_decode($row['paytm_business'],true);
return $res[$type];
}

function get_device($uid,$type){
$usql = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uid."' ");
$row = sql_fetch_array($usql);
$str = str_replace(["VERSION.RELEASE","VERSION.INCREMENTAL","VERSION.SDK.NUMBER","BOARD","BOOTLOADER","BRAND","MODEL","PRODUCT","SERIAL","ID","TIME","MANUFACTURER"],"",$row['device']);
$res = explode(":",$str);
return $res[$type];
}

function paytm_upi($text){
$res = explode(" ",$text);
$rrn = substr($text, -12);
$payer_name = $res[5];
$payee_vpa = explode(")",explode("(",$text)[1])[0];
$st = $res[2];
$amt = preg_replace("/[^0-9]/", "",$res[3]);
$arr = array("status"=>false,"message"=>"invalid request");
if($st=='received'){
$arr = array("status"=>true,"message"=>$text,"payer_name"=>$payer_name,"payee_vpa"=>$payee_vpa,"amount"=>$amt,"rrn"=>$rrn);
}

return json_encode($arr);
}


function sbipay_upi($text){
$res = explode(" ",$text);
$rrn = substr(explode(")",explode("(",$text)[1])[0],-12);
$payer_name = substr($res[9], 0, -4);
$payee_vpa = substr($res[9], 0, -4);
$st = $res[2];
$amt = substr($res[7],3);
if($st=='received'){
$arr = array("status"=>true,"message"=>$text,"payer_name"=>$payer_name,"payee_vpa"=>$payee_vpa,"amount"=>$amt,"rrn"=>$rrn);
}


return json_encode($arr);
}


function redirect($url,$time){
echo '<script>
setTimeout(
function(){
window.location = "'.$url.'" 
},'.$time.');
</script>';
}

function webdata($type){
$sql = sql_query("SELECT * FROM `tb_settings` WHERE base_url ='".$_SERVER['SERVER_NAME']."' ");
$res = sql_fetch_array($sql);
return $res[$type];
}

function my_qr_code($id){
$upi_id = get_upi_id($id,"upi_id");
$upi_name = get_upi_id($id,"upi_name");
$tx = urlencode("upi://pay?pa={$upi_id}&pn={$upi_name}&cu=INR");

$image = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=$tx&choe=UTF-8&chld=L|0";

 return imgbase64($image);

}

function imgbase64($image){

 if ($image !== false){
    return 'data:image/jpg;base64,'.base64_encode(file_get_contents($image));

}

}



function company_account($type){
$res = json_decode(webdata("company_account"),true);
return $res[$type];
}

function smsdata($type){
$res = json_decode(webdata("smsapi"),true);
return $res[$type];
}

function support($type){
$res = json_decode(webdata("support"),true);
return $res[$type];
}

function moneyformat($number) {
return number_format($number,2);
}

function date_time($format){
return date($format,time());
}

function base_url(){
return $_SERVER['SERVER_NAME'];
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function api_token_gen(){

return implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

}

if (substr($_SERVER['SERVER_NAME'], 0, 4) === 'www.')
{
    header('Location: https://'. webdata('socket'). substr($_SERVER['SERVER_NAME'], 4)); exit();
}

function GenRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateNumericOTP($n) {

    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468";

    // Iterate for n-times and pick a single character
    // from generator and append it to $result

    // Login for generating a random character from generator
    //     ---generate a random number
    //     ---take modulus of same with length of generator (say i)
    //     ---append the character at place (i) from generator to result

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }

    // Return result
    return $result;
}

function safe_str($value){

        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a", "-","+","=");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z", "","","");

        return strip_tags(str_replace($search, $replace, $value));
}

function str_escape($value){
global $conn;
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"');
        $replace = array("","","", "", '\"', "\'");

        return mysqli_real_escape_string($conn,$value);
}

function StrReplace($str,$fnd,$rep){

return str_replace($fnd,$rep,$str);

}











function SendMail($email_to, $email_subject, $email_message) {
		$email =$email_to;
		if($email){
			$cc ='infoteam@upi4india.in';
			$from_mail = "teampbsmm";
			$to      = $email;
			$from    = "UPI4INDIA";
			$subject = $email_subject;
		    $email_message=$email_message;
			$header = "From: ".$from." <".$from_mail.">\r\nCC:".$cc."\r\n";
			$header .= "MIME-Version: 1.0\n" . "Content-type: text/html; charset=iso-8859-1\n" ;
			if(mail($to, $subject, $email_message, $header));
		} else {

		  }
}



function hash_encrypt($data, $password) {
	$iv = substr(sha1(mt_rand()), 0, 16);
	$password = sha1($password);

	$salt = sha1(mt_rand());
	$saltWithPassword = hash('sha256', $password.$salt);

	$encrypted = openssl_encrypt(
	  "$data", 'aes-256-cbc', "$saltWithPassword", null, $iv
	);
	$msg_encrypted_bundle = "$iv:$salt:$encrypted";
	return $msg_encrypted_bundle;
}

/**
 * Returns decrypted original string
 */
function hash_decrypt($msg_encrypted_bundle, $password) {
	$password = sha1($password);

	$components = explode( ':', $msg_encrypted_bundle );
	$iv            = $components[0];
	$salt          = hash('sha256', $password.$components[1]);
	$encrypted_msg = $components[2];

	$decrypted_msg = openssl_decrypt(
	  $encrypted_msg, 'aes-256-cbc', $salt, null, $iv
	);

	if ( $decrypted_msg === false )
		return false;

	$msg = substr( $decrypted_msg, 41 );
	return $decrypted_msg;
}


function curl_post($url,$post_data,$header){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $post_data,
  CURLOPT_HTTPHEADER => $header
));

return curl_exec($curl);

curl_close($curl);
}

function curl_get($url,$header){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => $header
));

return curl_exec($curl);

curl_close($curl);
}
?>