$(document).ready(function () {
    $("#paymentForm").on('submit',(function(e) {
        e.preventDefault();
        $('#userammount').removeClass('borderline is-invalid');
        const amount = $('input#userammount').val();
        const minAmount = $('#minimumDeposit').val();

        if(amount == '' || parseInt(amount) < parseInt(minAmount)) {
            $("input#userammount").focus();
            $('#userammount').addClass('borderline is-invalid');
            return false;
        }

        $('#paymentdetail').modal({backdrop: 'static', keyboard: false})
        $('#paymentdetail').modal('show');

        document.getElementById('finalamount').value = userammount;

    }));


    $("#paymentdetailForm").on('submit',(function(e) {
        e.preventDefault();
        const name = $('input#name').val();
        const mobile = $('input#mobile').val();
        const email = $('input#email').val();


        $('#email').removeClass('borderline is-invalid');
        $('#mobile').removeClass('borderline is-invalid');
        $('#name').removeClass('borderline is-invalid');

        if ( name.length < 5 ) {
            $("input#name").focus();
            $('#name').addClass('borderline is-invalid');
            return false;
        }

        if (mobile === "") {
            $("input#mobile").focus();
            $('#mobile').addClass('borderline is-invalid');
            return false;
        }

        if (mobile.length < 10) {
            $("input#mobile").focus();
            $('#mobile').addClass('borderline is-invalid');
            return false;
        }


        if (echeck(email) === false) {
            $("input#email").focus();
            $('#email').addClass('borderline is-invalid');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "handler.php?action=saveSessionForPayment",
            data: {
                'name' : name,
                'mobile' : mobile,
                'email' : email,
                'amount' : $('#userammount').val(),
            },
            dataType: 'JSON',

            success: function() {
                window.location.href = "checkout.php";
            },

            error : function (err) {
                console.log(err);
                alert('d');
            }
        });


    }));

    $("#redeemButton").on('click',(function(e) {
        $('.rechargeOptions').hide()
        $('#redeemOptions').show()
    }));

    $("#rechargeButton").on('click',(function(e) {
        $('.rechargeOptions').show()
        $('#redeemOptions').hide()
    }));

    $('#redeemForm').on('submit', function (e){
        e.preventDefault();

        let validator = $('#validationMessage');
        let input = $('#giftCard');
        validator.html('')

        const voucher = input.val();

        if (voucher.length !== 16 ) {
            input.val();
            validator.html('<b>Invalid voucher details</b>')
            input.addClass('is-invalid')
            return false;
        }

        let spinner = $('#spinner-div');
        spinner.show();

        $.ajax({
            type: "POST",
            url: "handler.php?action=validate_voucher",
            dataType : 'JSON',
            data: {
                'voucher' : voucher
            },
            success :function (res) {
                successHandler(res.message, function (){
                    setTimeout(function () {
                        window.location.href = 'index.php'
                    }, 500)
                })
            },
            error :function (error) {
                console.log(error);
                errorHandler(JSON.parse(error.responseText).message)
            },
        })
    })
});

function errorHandler(message = '')
{
    $("#spinner-div").hide();
    let responseHandler = $("#responseHandler");
    let messageHandler = $("#responseMessage");

    if (message.length > 5){
        responseHandler.show();
        responseHandler.css('display', 'flex');
        messageHandler.html(message);
    }

    setTimeout(function () {
        messageHandler.html('');
        responseHandler.hide();
    }, 2000);
}

function successHandler(message = '', callback = function () {}) {
    $("#spinner-div").hide();

    let responseHandler = $("#responseHandler");
    let messageHandler = $("#responseMessage");

    if(message.length > 5) {
        responseHandler.show();
        responseHandler.css('display', 'flex');
        messageHandler.html(message);
        messageHandler.removeClass('badge-danger')
        messageHandler.addClass('badge-success')
    }

    setTimeout(function () {
            messageHandler.html('');
            responseHandler.hide();
            callback()
        },
        1500);
}