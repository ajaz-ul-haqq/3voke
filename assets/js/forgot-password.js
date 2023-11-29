$.validator.setDefaults({
	submitHandler: function() {
	}
});

$().ready(function() {
	$("#forgotform").validate({
		rules: {
			fmobile: {
				required: true,
				number: true,
				minlength: 10
			},
		},
	});

	$("#finalforgotform").validate({
		rules: {
			password1 : {
				required: true

			},
			password2: {
				required: true

			}
		},
	});
});

$(document).ready(function () {

	$("#forgotform").on('submit',(function(e) {
		e.preventDefault();

		$('#mobile').removeClass('is-invalid');

		const mobile = $('input#mobile').val();

		if (mobile === '') {
			$("input#mobile").focus();
			$('#mobile').addClass('borderline');
			$('#mobile').addClass('is-invalid');
			return false;
		}


		$("#spinner-div").show();
		$("#spinner-div").css('display', 'flex');

		$.ajax({
			type: "POST",
			url: "handler.php?action=password_recovery",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,

			success: function(response)
			{
				successHandler('OTP sent successfully..', function (){
					$('#otpform').modal({backdrop: 'static', keyboard: false})
					$('#otpform').modal('show');
				})
			},

			error : function (err) {
				errorHandler(JSON.parse(err.responseText).message);
			}
		});
	}));


	$("#otpsubmitForm").on('submit',(function(e) {
		e.preventDefault();

		const otp = $('input#otp').val();
		const userid = $('input#userid').val();

		if (otp === "") {
			$("input#otp").focus();
			$('#otp').addClass('borderline');
			$('#otp').addClass('is-invalid');
			return false;
		}


		$("#spinner-div").show();
		$("#spinner-div").css('display', 'flex');
		$('#otpform').modal('hide');

		$.ajax({
			type: "POST",
			url: "handler.php?action=verify_otp",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,

			success: function(res) {
				document.getElementById('appCapsule').style.display = 'none';
				setTimeout(function (){
					successHandler('OTP verified successfully');
				}, 1000)
				document.getElementById('appCapsuleForChangePassword').style.display = 'block';
			},

			error: function (err) {
				let message = (JSON.parse(err.responseText).message);
				errorHandler(message);
				$('#otp').addClass('borderline');
				$('#otp').addClass('is-invalid');
				$('#otp').val('');
				setTimeout(function (){
					$('#otpform').modal('show');
				}, 500)
			}
		});


	}));

	$("#finalforgotform").on('submit',(function(e) {
		e.preventDefault();

		$('#password2').removeClass('is-invalid');
		$('#password1').removeClass('is-invalid');

		const password1 = $('input#password1').val();
		const password2 = $('input#password2').val();

		if (password1 === '') {
			$("input#password1").focus();
			$('#password1').addClass('borderline');
			$('#password1').addClass('is-invalid');
			return false;
		}

		if ( password2 === '') {
			$("input#password2").focus();
			$('#password2').addClass('borderline');
			$('#password2').addClass('is-invalid');
			return false;
		}

		if (password1 !== password2) {
			$("input#password1").focus();
			$('#password1').addClass('borderline');
			$('#password1').addClass('is-invalid');
			$('#password2').addClass('borderline');
			$('#password2').addClass('is-invalid');
			return false;
		}

		$("#spinner-div").show();
		$("#spinner-div").css('display', 'flex');

		$.ajax({
			type: "POST",
			url: "handler.php?action=change_password",
			dataType : 'JSON',
			data: {
				'password' : password2,
			},

			success: function(response) {
				successHandler('Password changed successfully', function () {
					window.location.href = 'login.php';
				})
			},

			error: function (err) {
				errorHandler(JSON.parse(err.responseText).message);
			}
		});
	}));
});