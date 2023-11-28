$.validator.setDefaults({
	submitHandler: function() {
	}
});

$().ready(function() {
	$("#Register").validate({

		rules: {

			mobile: {
				required: true,
				minlength: 10
			},

			email: {
				required: true,
				email: true
			},


			password: {
				required: true,
				minlength: 5
			},
			rcode: {
				required: true,
				minlength: 6
			},

			remember: "required",

		},
		messages: {

			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},

			email: "Please enter a valid email address",
			remember: "Please accept our policy",
		}

	});
});

$().ready(function() {
	$("#loginForm").validate({

		rules: {

			login_mobile: {
				required: true,
				minlength: 10

			},

			login_password: {
				required: true,
				minlength: 5
			},
		},
		messages: {

			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},

			email: "Please enter a valid email address",
			remember: "Please accept our policy",
		}

	});
});

$(document).ready(function () {

	$("#Register").on('submit',(function(e) {
		e.preventDefault();
		var mobile = $('input#mobile').val();
		var email = $('input#email').val();
		var password = $('input#password').val();
		var rcode = $('input#rcode').val();

		$('#mobile').removeClass('is-invalid');
		$('#email').removeClass('is-invalid');
		$('#password').removeClass('is-invalid');

		if ( mobile == '' && mobile.length < 10 ) {
			$("input#mobile").focus();
			$('#mobile').addClass('borderline');
			$('#mobile').addClass('is-invalid');
			return false;
		}

		if (echeck(email)== "") {
			$("input#email").focus();
			$('#email').addClass('borderline');
			$('#email').addClass('is-invalid');
			return false;
		}


		if ((password)== "") {
			$("input#password").focus();
			$('#password').addClass('borderline');
			$('#password').addClass('is-invalid');
			return false;
		}
		if (password.length<5) {
			$("input#password").focus();
			$('#password').addClass('borderline');
			$('#password').addClass('is-invalid');
			return false;
		}
		if ((rcode)== "") {
			$("input#rcode").focus();
			$('#rcode').addClass('borderline');
			return false;
		}
		if($('#remember').is(':checked')){}
		else{return false;}


		$("#spinner-div").show();
		$("#spinner-div").css('display', 'flex');

		$.ajax({
			type: "POST",
			url: "handler.php?action=user_registration",
			dataType : 'JSON',
			data: {
				'mobile' : mobile,
				'email' : email,
				'password' : password,
				'rcode' : rcode,
			},

			success: function(res) {
				successHandler(res.message, function () {
					window.location.href = 'login.php'
				});
			},

			error : function (err) {
				errorHandler(JSON.parse(err.responseText).message)
			}
		});


	}));


	$("#loginForm").on('submit',(function(e) {
		e.preventDefault();

		var loginmobile = $('input#login_mobile').val();
		var loginpassword = $('input#login_password').val();

		if ((loginmobile)== "") {
			$("input#login_mobile").focus();
			$('#login_mobile').addClass('borderline');
			return false;
		}
		if (loginmobile.length<10) {
			$("input#login_mobile").focus();
			$('#login_mobile').addClass('borderline');
			return false;
		}

		if ((loginpassword)== "") {
			$("input#login_password").focus();
			$('#login_password').addClass('borderline');
			return false;
		}

		if (loginpassword.length<5) {
			$("input#login_password").focus();
			$('#login_password').addClass('borderline');
			return false;
		}
		$("#spinner-div").show();
		$("#spinner-div").css('display', 'flex');

		$.ajax({
			type: "POST",
			url: "postLogin.php",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,

			success: function(response) {
				successHandler(response.message, function (){
					window.location.href = "index.php"
				})
			},

			error : function (error) {
				errorHandler(error.responseJSON.message);
			}
		});
	}));


	function errorHandler(message = '')
	{
		$("#spinner-div").hide();

		if (message.length > 5){
			$("#responseHandler").show();
			$("#responseHandler").css('display', 'flex');
			$("#responseMessage").html(message);
		}

		setTimeout(function () {
			$("#responseMessage").html('');
			$("#responseHandler").hide();
		}, 2000);
	}

	function successHandler(message = '', callback = function () {}) {
		$("#spinner-div").hide();

		if(message.length > 5) {
			$("#responseHandler").show();
			$("#responseHandler").css('display', 'flex');
			$("#responseMessage").html(message);
			$("#responseMessage").removeClass('badge-danger')
			$("#responseMessage").addClass('badge-success')
		}

		setTimeout(function () {
				$("#responseMessage").html('');
				$("#responseHandler").hide();
				callback()
			},
			1500);
	}

	$("#otpsubmitForm").on('submit',(
		function(e) {
			e.preventDefault();

			var otp = $('input#otp').val();


			if ((otp)== "") {
				$("input#otp").focus();
				$('#otp').addClass('borderline');
				return false;
			}


			$("#spinner-div").show();
			$("#spinner-div").css('display', 'flex');


			document.getElementById('failedOTPMessage').innerHTML = '';

			$.ajax({
				type: "POST",
				url: "handler.php?action=verify_otp",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,

				success: function (response) {
					console.log(response);
					$('#otpform').modal({backdrop: 'static', keyboard: false})
					$('#otpform').modal('hide');

					$('#reg_otp').addClass('disabled');
					$('#mobile').removeClass('is-invalid')
					$('#mobile').addClass('is-valid')
					document.getElementById('mobile').disabled = true;
					document.getElementById('registerButton').disabled = false;

					setTimeout(() => {
						successHandler('OTP verified successfully');
					}, 1000)
				},

				error : function (err) {
					$("#spinner-div").hide();
					$("#spinner-div").css('display', 'none');
					$('#otp').addClass('is-invalid')
					document.getElementById('failedOTPMessage').innerHTML = ('<font size="2" style="color:#f00;">'+ (JSON.parse(err.responseText).message) +'</font>');
					document.getElementById('otp').value = '';
				}
			});
		}));
});

function mobileveryfication()
{
	const mobile = $('input#mobile').val();

	$('#mobile').removeClass('is-invalid');

	if ( (mobile) === "") {
		$("input#mobile").focus();
		$('#mobile').addClass('borderline');
		$('#mobile').addClass('is-invalid');
		return false;
	}

	if (mobile.length < 10) {
		$("input#mobile").focus();
		$('#mobile').addClass('borderline');
		$('#mobile').addClass('is-invalid');
		return false;
	}

	$("#spinner-div").show();
	$("#spinner-div").css('display', 'flex');

	$.ajax({
		type: "POST",
		data:"mobile=" + mobile+ "& type=" + "mobile",
		url: "handler.php",

		success: function (response) {
			console.log(response);
			successHandler(response.message);
			setTimeout(() => {
				$('#otpform').modal({backdrop: 'static', keyboard: false})
				$('#otpform').modal('show');
			}, 1000)
		},

		error: function (err) {
			console.log(err);
			let message = (JSON.parse(err.responseText).message);
			errorHandler(message)
		}
	});
}