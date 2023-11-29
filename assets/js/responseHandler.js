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