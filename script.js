'use strict';

let inputFields = $('input[type=file]');
$('form').on('change', function(event) {
    if (inputFields.length < 5 && inputFields[inputFields.length - 1].files.length > 0) {
        const inputAcceptAttr = $(event.currentTarget).data('input-accept');
        const newInput = `<div>
                                    <input type="file"
                                           name="myFile-${ inputFields.length }" 
                                           accept="${ inputAcceptAttr }">
                                </div><br>`;
        $('.label').append(newInput);
        inputFields = $('input[type=file]');
    }
});

$('button[type=submit]').on('click', function(event) {
    event.preventDefault();

    const photos = $('input[type="file"]'),
        formElement = $('form'),
        ajaxUrl = formElement.data('upload-handler-url'),
        formdata = new FormData(document.querySelector('form')),
        button = $(event.currentTarget);

    button.text('Загрузка...').attr('disabled', 'disabled');

    for (let [name, value] of formdata) {
        if (value.size === 0) formdata.delete(name);
    }

    let message;

    $.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: formdata,
        dataType: 'text',
        processData: false,
        contentType: false,
        success: function(response) {
            if (typeof response.error === 'undefined') {
                document.querySelector('form').reset();
                inputFields.each(function(index, element) {
                    if (index !== 0) {
                        $(element).remove();
                    }
                });
                inputFields = $('input[type=file]');
                message = response;
            } else {
                message = 'ОШИБКИ ОТВЕТА сервера: ' + response.error;
            }
            printMessage('.message', message);
            button.text('Загрузить').removeAttr('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            message = 'ОШИБКИ AJAX запроса: ' + textStatus;
            printMessage('.message', message);
            button.text('Загрузить').removeAttr('disabled');
        }
    });

    function printMessage(selector, message) {
        const messageElement = $(selector);
        if (messageElement.length > 0) messageElement.remove();
        formElement.append(`<div class="message">${ message }</div>`);
    }
});
