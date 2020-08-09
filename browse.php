<style>
    body {
        background-color: #fff;
        color: #000;
    }
</style>

<?php

$uploadDirPath = $_SERVER['DOCUMENT_ROOT'] . "/upload/";
$filesList = scandir($uploadDirPath);

if (isset($_POST["del"])) {
    foreach ($_POST as $key => $fileName) {
        if ($key !== "del") {
            foreach ($filesList as $i => $image) {
                if ($fileName == $image) {
                    unlink($uploadDirPath . $fileName);
                }
            }
        };
    };
};
?>
    <a href="/">Вернуться к странице загрузки</a>
    <br>
    <br>
<?php
$filesList = scandir($uploadDirPath);

unset($filesList[0], $filesList[1]);

if (!empty($filesList)) { ?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>"
          method="post"
          id="delForm"
          style="
            display:flex;
            flex-wrap: wrap;
          "
    >
        <?php
        asort($filesList);
        foreach ($filesList as $fileName) {
            ?>
            <label style="margin-right: 10px">
                <img src="<?= "/upload/" . $fileName ?>" alt="img" style="height: 200px;">
                <p style="margin: 0;">Имя файла: <?= $fileName ?></p>
                <p style="margin: 0;">Размер файла: <?php printFileSize($uploadDirPath . $fileName) ?></p>
                <p style="margin: 0;">Дата загрузки: <?= date("d.m.Y", filemtime($uploadDirPath . $fileName)) ?> г.</p>
                <input type="checkbox" name="image<?= $fileName ?>ToDel" value="<?= $fileName ?>">Удалить
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
    echo "Загруженных изображений нет";
};

function printFileSize(string $pathToTheFile)
{
    $fileSize = filesize($pathToTheFile);
    if ($fileSize <= 10240) {
        echo $fileSize . "b";
    } else if ($fileSize > 10240 && $fileSize <= 1048576) {
        echo round($fileSize / 1024) . "Kb";
    } else {
        echo round($fileSize / 1048576) . "Mb";
    }
}
