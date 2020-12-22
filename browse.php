<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/helper.php';
$upload_path = get_upload_path();

$files_list = scandir( $upload_path );
if ( isset( $_POST[ "del" ] ) ) {
    foreach ( $_POST as $file_name ) {
        if ( in_array( $file_name, $files_list ) ) {
            unlink( $upload_path . $file_name );
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
    <title>PHP Gallery | Browse images</title>
    <link rel="stylesheet" href="css/browse.css">
</head>
<body>
<a href="<?= get_url() ?>">Вернуться к странице загрузки</a>
<br>
<br>
<?php
$files_list = array_diff( scandir( $upload_path, 0 ), array( '..', '.' ) );

if ( !empty( $files_list ) ) { ?>

    <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>"
          method="post"
          id="delForm"
          class="form-del">
        <?php
        foreach ( $files_list as $file_name ) {
            ?>
            <label class="form-del__label">
                <img src="<?= "/upload/" . rawurlencode($file_name) ?>"
                     alt="img"
                     class="form-del__image">
                <p class="form-del__text">Имя файла: <?= $file_name ?></p>
                <p class="form-del__text">Размер файла: <?= get_file_size( $upload_path .
                                                                                             $file_name )
                    ?></p>
                <p class="form-del__text">Дата загрузки: <?= date( "d.m.Y", filemtime(
                        $upload_path .
                                                                                             $file_name )
                ) ?>
                    г.</p>
                <span><input type="checkbox"
                             name="image<?= $file_name ?>ToDel"
                             value="<?= $file_name ?>">Удалить</span>
            </label>
            <?php
        }
        ?>
    </form>
    <button type="submit"
            class="form-del__button"
            form="delForm"
            name="del"
            value="true">Удалить отмеченные изображения</button>
    <?php
} else {
    echo "<div>Загруженных изображений нет</div>";
};
?>
</body>
</html>
