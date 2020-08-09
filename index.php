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

<form enctype="multipart/form-data">
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
