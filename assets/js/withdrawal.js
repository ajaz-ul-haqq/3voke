$(document).ready(function () {
    $("#withdrawlRequest").on('submit',(function(e) {
        e.preventDefault();

        const amount = $('input#amount').val();

        $('#paymentdetail').modal('hide');
        $("#spinner-div").show();
        $("#spinner-div").css('display', 'flex');

        $.ajax({
            type: "POST",
            url: "handler.php?action=requestWithdrawl",
            data: {
                'amount' : amount,
                'upi' : document.getElementById('upi').value,
                'name' : document.getElementById('name').value,
            },
            dataType : 'JSON',

            success: function(res) {
                successHandler(res.message, function (){
                    window.location.reload();
                })
            },

            error : function (err) {
                errorHandler(err.responseJSON.message)
                $('#paymentdetail').modal('show');
            }
        });
    }));

    $("#paymentForm").on('submit',(function(e) {
        e.preventDefault();
        $('input#amount').removeClass('borderline is-invalid')
        const amount = $('input#amount').val();
        const minimumWithdrawl = $('#minimumWithdrawl').val()

        if (amount < minimumWithdrawl) {
            $('input#amount').addClass('borderline is-invalid')
            return false;
        }
        $('#paymentdetail').modal({backdrop: 'static', keyboard: false})
        $('#paymentdetail').modal('show');
    }));
});



function errorHandler(message = '')
{
    $("#spinner-div").hide();
    let responseHandler = $("#responseHandler");
    let messageHandler = $("#responseMessage");

    if (message.length > 0){
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

    if(message.length > 0) {
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
