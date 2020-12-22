'use strict';

let inputField = $('input[type=file]');
$(inputField).on('change', function(event) {
    const _this = event.currentTarget;
    const maxFilesAmount = parseInt($(_this).data('max-files-amount'));
    if (_this.files.length <= maxFilesAmount) return;
    $(_this).val('');
    $('.message').html('').append(`Ошибка! Разрешается выбрать не более ${ maxFilesAmount } файлов`);
});


$('button[type=submit]').on('click', function(event) {
    event.preventDefault();

    const photos = $('input[type="file"]'),
        formElement = $('form'),
        ajaxUrl = formElement.data('upload-handler-url'),
        formdata = new FormData(document.querySelector('form')),
        button = $(event.currentTarget);

    button.text('Загрузка...').attr('disabled', 'disabled');

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
                    $('.message').html('').append(message[key]);
                }
            }

            button.text('Загрузить').removeAttr('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            message.error = 'ОШИБКИ AJAX запроса: ' + textStatus;
            $('.message').html(message.error);
            button.text('Загрузить').removeAttr('disabled');
        }
    });

});
