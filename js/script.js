'use strict';

let inputField = $('input[type=file]');
$(inputField).on('change', function(event) {
    $('.message').remove();
    const _this = event.currentTarget;
    const maxFilesAmount = parseInt($(_this).data('max-files-amount'));
    if (_this.files.length <= maxFilesAmount) return;
    $(_this).val('');
    $('form').append(`<div class="message">Ошибка! Разрешается выбрать не более ${ maxFilesAmount } файлов</div>`);
});


$('button[type=submit]').on('click', function(event) {
    event.preventDefault();

    const photos = $('input[type="file"]'),
        formElement = $('form'),
        ajaxUrl = formElement.data('upload-handler-url'),
        formdata = new FormData(document.querySelector('form')),
        button = $(event.currentTarget);

    $('.message').remove();
    button.text('Загрузка...').attr('disabled', 'disabled');

    for (let [name, value] of formdata) {
        if (value.size === 0) formdata.delete(name);
    }

    let message = {};

    $.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: formdata,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(response) {
            if (typeof response.error === 'undefined') {
                document.querySelector('form').reset();
                message = {...response};
            } else {
                message.error = 'ОШИБКИ ОТВЕТА сервера: ' + response.error;
            }

            for (let key in message) {
                if (message.hasOwnProperty(key)) {
                    formElement.append(`<div class="message">${ message[key] }</div>`);
                }
            }

            button.text('Загрузить').removeAttr('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            message.error = 'ОШИБКИ AJAX запроса: ' + textStatus;
            formElement.append(`<div class="message">${ message.error }</div>`);
            button.text('Загрузить').removeAttr('disabled');
        }
    });

});
