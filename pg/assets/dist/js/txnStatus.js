function TxnStatus(){
	
   $.ajax({ 
            url: "../system/txnStatus",
			type: "POST", 
            success: function(result) {
			var obj = JSON.parse(result);
			
            if(obj.status=="SUCCESS"){
				
			document.getElementById("qrcode").innerHTML = "<img src=\'../assets/img/success.gif\' width=\'150\'>";	
            document.getElementById("status").value = obj.status;
            document.getElementById("message").value = obj.message;
            document.getElementById("hash").value = obj.hash;
            document.getElementById("checksum").value = obj.checksum;
			
			setTimeout(function(){ 
			document.getElementById("formSubmit").submit();
            }, 2000);

			}  

			  
            }
    });
	
}

setInterval(function(){ 
TxnStatus();
}, 10000);