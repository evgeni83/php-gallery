<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/helper.php';
$limits = get_limits();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Gallery</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<br>
<br>

<form
        class="upload-form"
        enctype="multipart/form-data"
        data-input-accept="<?= implode( $limits[ 'file_types' ], ', ' ) ?>"
        data-upload-handler-url="<?= get_url( '/upload_handler.php' ) ?>">
    <label class="label">
        Загрузите не более <?= $limits[ 'max_files_amount' ] ?> картинок<br>
        размер каждой: не более <?= round( $limits[ 'max_file_size' ] / ( 1024 ** 2 ), 2 ) ?> МБайт<br>
        разширение: <?php
        foreach ( $limits[ 'file_types' ] as $key => $file_type ) {
            $file_type = str_replace( 'image/', '', $file_type );
            if ( $key < count( $limits[ 'file_types' ] ) - 1 ) {
                echo $file_type . ', ';
            } else {
                echo $file_type;
            }
        }
        ?>
        <div class="input-wrapper">
            <input
                    class="input-files"
                    multiple
                    type="file"
                    name="myFile[]"
                    data-max-files-amount="<?= $limits[ 'max_files_amount' ] ?>"
                    accept="<?= implode( $limits[ 'file_types' ], ', ' ) ?>">
        </div>
    </label>
    <button class="upload-button"
            type="submit"
            name="upload">Загрузить
    </button>
</form>

<a href="<?= get_url( '/browse.php' ) ?>">Посмотреть загруженные фото</a>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>
