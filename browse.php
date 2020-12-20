<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/helper.php';
$upload_path = get_upload_path();

$files_list = scandir( $upload_path );
if ( isset( $_POST[ "del" ] ) ) {
    foreach ( $_POST as $file_name ) {
        if ( in_array( $file_name, $files_list ) ) {
            unlink( $upload_path . $file_name );
        }
    };
};

function get_file_size( string $path_to_the_file ): string {
    $file_size = filesize( $path_to_the_file );
    if ( $file_size <= 10240 ) {
        return $file_size . "b";
    } else if ( $file_size > 10240 && $file_size <= 1048576 ) {
        return round( $file_size / 1024 ) . "Kb";
    } else {
        return round( $file_size / 1048576 ) . "Mb";
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
    <style>
        body {
            background-color: #fff;
            color: #000;
        }
    </style>
</head>
<body>
<a href="<?= get_url() ?>">Вернуться к странице загрузки</a>
<br>
<br>
<?php
$files_list = array_diff(scandir( $upload_path, 0 ), array('..', '.'));

if ( !empty( $files_list ) ) { ?>

    <form action="<?= $_SERVER[ 'PHP_SELF' ] ?>"
          method="post"
          id="delForm"
          style="
            display:flex;
            flex-wrap: wrap;
          ">
        <?php
        foreach ( $files_list as $file_name ) {
            ?>
            <label style="margin-right: 10px">
                <img src="<?= "/upload/" . $file_name ?>" alt="img" style="height: 200px;">
                <p style="margin: 0;">Имя файла: <?= $file_name ?></p>
                <p style="margin: 0;">Размер файла: <?= get_file_size( $upload_path . $file_name ) ?></p>
                <p style="margin: 0;">Дата загрузки: <?= date( "d.m.Y", filemtime( $upload_path . $file_name ) ) ?>
                    г.</p>
                <span><input type="checkbox" name="image<?= $file_name ?>ToDel" value="<?= $file_name ?>">Удалить</span>
            </label>
            <br>
            <br>
            <?php
        }
        ?>
    </form>
    <button type="submit" form="delForm" name="del" value="true">Удалить отмеченные изображения</button>

    <br>
    <br>
    <?php
} else {
    echo "<div>Загруженных изображений нет</div>";
};
?>
</body>
</html>
