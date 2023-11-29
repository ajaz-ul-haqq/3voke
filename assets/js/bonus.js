$.validator.setDefaults({
	submitHandler: function() {
	}
});

$().ready(function() {
	const applicableAmount = $('#applicableAmount').html();
	$("#bonusForm").validate({
		rules: {
			bonusammount: {
				required: true,
				number: true,
				min: 1200,
				max : applicableAmount,
			},
		},
		messages: {
			email: "Please enter a valid email address",
			remember: "Please accept our policy",
		}
	});
});
$(document).ready(function () {
	$("#bonusForm").on('submit',(function(e) {
		e.preventDefault();

		const amount = $('input#bonusammount').val();

		if (amount < 1200) {
			$("input#bonusammount").focus();
			$('#userammount').addClass('borderline');
			return false;
		}


		$('#bonus').modal('hide');
		$("#spinner-div").show();
		$("#spinner-div").css('display', 'flex');

		$.ajax({
			type: "POST",
			url: "handler.php?action=redeemBonus",
			data : {
				amount : amount,
			},
			dataType : 'JSON',

			success: function(res) {
				successHandler('Bonus Redeemed Successfully', function (){
					window.location.reload();
				})
			},

			error : function (res) {
				errorHandler('Oops!! Something went wrong here')
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
});