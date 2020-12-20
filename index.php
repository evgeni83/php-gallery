<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/helper.php';
$limits = get_limits();

$input_accept = '';
foreach ( $limits[ 'file_types' ] as $key => $file_type ) {
    if ( $key < count( $limits[ 'file_types' ] ) - 1 ) {
        $input_accept .= $file_type . ', ';
    } else {
        $input_accept .= $file_type;
    }
};


?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Gallery</title>
    <style>
        body {
            background-color: #fff;
            color: #000;
        }
    </style>
</head>
<body>
<br>
<br>

<form
        enctype="multipart/form-data"
        data-input-accept="<?= $input_accept ?>"
        data-upload-handler-url="<?= get_url('/upload_handler.php') ?>">
    <div class="label">
        Загрузите картинку<br><br>
        размер: не более <?= round( $limits[ 'max_file_size' ] / ( 1024 ** 2 ), 2 ) ?> МБайт<br>
        разширение: <?php
        foreach ( $limits[ 'file_types' ] as $key => $file_type ) {
            $file_type = str_replace( 'image/', '', $file_type );
            if ( $key < count( $limits[ 'file_types' ] ) - 1 ) {
                echo $file_type . ', ';
            } else {
                echo $file_type;
            }
        }
        ?><br><br><br>
        <div>
            <input
                    type="file"
                    name="myFile-0"
                    accept="<?= $input_accept ?>">
        </div>
        <br>
    </div>
    <br>
    <button type="submit" name="upload">Загрузить</button>
    <br>
</form>
<br>
<br>
<a href="<?= get_url('/browse.php') ?>">Посмотреть загруженные фото</a>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="script.js"></script>

</body>
</html>
