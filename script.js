'use strict';

let inputFields = $('input[type=file]');
$('form').on('change', function () {
    if (inputFields.length < 5 && inputFields[inputFields.length - 1].files.length > 0) {
        $('label').append(`<input type="file" name="myFile-${ inputFields.length }">`);
        inputFields = $('input[type=file]');
    }
});

$('button[type=submit]').on('click', function (event) {
    event.preventDefault();

    const photos = $('input[type="file"]'),
        formdata = new FormData(document.querySelector('form'));

    for(let [name, value] of formdata) {
        if (value.size === 0) formdata.delete(name);
    }

    let message;

    $.ajax({
        url: './upload_handler.php',
        type: 'POST',
        data: formdata,
        dataType: 'text',
        processData: false,
        contentType: false,
        success: function (response) {
            if (typeof response.error === 'undefined') {
                document.querySelector('form').reset();
                inputFields.each(function (index, element) {
                    if (index !== 0) {
                        $(element).remove();
                    }
                })
                inputFields = $('input[type=file]');
                message = response;
            } else {
                message = 'ОШИБКИ ОТВЕТА сервера: ' + response.error;
            }
            printMessage(".message", message);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            message = 'ОШИБКИ AJAX запроса: ' + textStatus;
            printMessage(".message", message);
        }
    });

    function printMessage (selector, message) {
        const messageElement = $(selector);
        if (messageElement.length > 0) messageElement.remove();
        $('form').append(`<div class="message">${message}</div>`);
    }
});
