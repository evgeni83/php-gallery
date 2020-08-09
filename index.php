<?php

echo '<pre>';
print_r($_FILES);
echo '</pre>';

if (!empty($_FILES)) {
    if (count($_FILES) === 1 && $_FILES[0]['size'] == 0) {
        echo "Файл не выбран";
    } else {
        foreach ($_FILES as $file) {
            if ($file['size'] > 0) {
                if ($file['error'] > 0) {
                    echo 'Ошибка';
                } else {
                    if (!($file["type"] === "image/jpeg" ||
                        $file["type"] === "image/png" ||
                        $file["type"] === "image/jpg")) {
                        echo "<br>неверный формат файла";
                    } else if ($file['size'] > 5242880) {
                        echo "<br>слишком большой размер файла";
                    } else {
                        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
                        move_uploaded_file($file['tmp_name'], $uploadPath . $file['name']);
                        echo "<br>файл загружен!";
                    }
                }
            }
        }
    }
}


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

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <label>
        Загрузите картинку<br><br>
        размер: не более 5 МБайт<br>
        разширение: jpg, jpeg, png<br><br><br>
        <input type="file" name="myFile-0">
    </label>
    <br>
    <br>
    <button type="submit" name="upload">Загрузить</button>
</form>
<br>
<br>
<a href="/browse.php">Посмотреть загруженные фото</a>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="script.js"></script>

</body>
</html>
