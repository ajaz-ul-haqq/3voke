function TxnStatus(str,hash,checksum){

            if(str=="success"){
				
			document.getElementById("qrcode").innerHTML = "<img src=\'../assets/img/success.gif\' width=\'150\'>";	
            document.getElementById("status").value = "SUCCESS";
            document.getElementById("message").value = "Txn Test Success";
            document.getElementById("hash").value = hash;
            document.getElementById("checksum").value = checksum;
			
			setTimeout(function(){ 
			document.getElementById("formSubmit").submit();
            }, 2000);

			}else{
				
			document.getElementById("qrcode").innerHTML = "<img src=\'../assets/img/failed.png\' width=\'150\'>";	
            document.getElementById("status").value = "FAILED";
            document.getElementById("message").value = "Txn Failed";
            document.getElementById("hash").value = "false";
            document.getElementById("checksum").value = "false";
			
			setTimeout(function(){ 
			document.getElementById("formSubmit").submit();
            }, 2000);

			}				
}