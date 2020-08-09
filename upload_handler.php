<?php

if (!empty($_FILES)) {
    foreach ($_FILES as $file) {
        if ($file['size'] > 0) {
            if ($file['error'] > 0) {
                echo '<div>Ошибка</div>';
            } else {
                if (!($file["type"] === "image/jpeg" ||
                    $file["type"] === "image/png" ||
                    $file["type"] === "image/jpg")) {
                    echo '<div>Неверный формат файла ' . $file['name'] . '</div>';
                } else if ($file['size'] > 5242880) {
                    echo '<div>Слишком большой размер файла ' . $file['name'] . '</div>';
                } else {
                    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
                    move_uploaded_file($file['tmp_name'], $uploadPath . $file['name']);
                    echo '<div>Файл ' . $file['name'] . ' загружен!</div>';
                }
            }
        }
    }
} else {
    echo "Файл не выбран";
}
