'use strict';

let inputFields = $('input');
$('form').on('change', function () {
    if (inputFields.length < 5 && inputFields[inputFields.length - 1].files.length > 0) {
        $('label').append(`<br><br><input type="file" name="myFile-${ inputFields.length }">`);
        inputFields = $('input');
    }
})


$('button[type=submit]').on('click', function (event) {
    event.preventDefault();

    const photos = $('input[type="file"]'),
        formdata = new FormData();

    photos.each(function (index, photo) {
        if (photo.files[0]) {
            formdata.append(photo.name, photo.files[0].name);
        }
    });

    for (let key of formdata.keys()) {
        console.log(`${key}: ${formdata.get(key)}`);
    }

    $('form').trigger('submit');

    // $.ajax({
    //     url: '/index.php',
    //     type: 'POST',
    //     data: formdata,
    //     // cache: false,
    //     // dataType: 'text',
    //     processData: false, // Не обрабатываем файлы (Don't process the files)
    //     contentType: false, // Так jQuery скажет серверу что это строковой запрос
    //     success: function (response) {
    //
    //         // Если все ОК
    //
    //         if (typeof response.error === 'undefined') {
    //             // Файлы успешно загружены, делаем что нибудь здесь
    //
    //             console.log(response);
    //             // выведем пути к загруженным файлам в блок '.ajax-respond'
    //
    //             // var files_path = respond.files;
    //             // var html = '';
    //             // $.each( files_path, function( key, val ){ html += val +'<br>'; } )
    //             console.log('OK');
    //         } else {
    //             console.log('ОШИБКИ ОТВЕТА сервера: ' + response.error);
    //         }
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) {
    //         console.log('ОШИБКИ AJAX запроса: ' + textStatus);
    //     }
    // });
});
