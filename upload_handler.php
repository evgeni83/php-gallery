<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/helper.php';
$limits = get_limits();
$upload_path = get_upload_path();

if ( !empty( $_FILES ) ) {
    foreach ( $_FILES as $file ) {
        if ( $file[ 'size' ] > $limits[ 'min_file_size' ] ) {
            if ( $file[ 'error' ] > 0 ) {
                echo '<div>Ошибка</div>';
            } else {
                if ( !( in_array( $file[ "type" ], $limits[ 'file_types' ] ) ) ) {
                    $message_html = '<div>Ошибка! Формат файла "' . $file[ 'name' ] . '" должен быть: ';

                    foreach ( $limits[ 'file_types' ] as $key => $file_type ) {
                        $file_type = str_replace( 'image/', '', $file_type );
                        if ( $key < count( $limits[ 'file_types' ] ) - 1 ) {
                            $message_html .= $file_type . ' или ';
                        } else {
                            $message_html .= $file_type;
                        }
                    }

                    $message_html .= '</div>';

                    echo $message_html;

                } else if ( $file[ 'size' ] > $limits[ 'max_file_size' ] ) {

                    $message_html = '<div>Ошибка! Размер файла "' . $file[ 'name' ] . '" равен ';
                    $message_html .= round( $file[ 'size' ] / ( 1024 ** 2 ), 2 );
                    $message_html .= ' МБайт. Размер не должен превышать ';
                    $message_html .= round( $limits[ 'max_file_size' ] / ( 1024 ** 2 ), 2 );
                    $message_html .= ' МБайт</div>';
                    echo $message_html;

                } else {

                    move_uploaded_file( $file[ 'tmp_name' ], $upload_path . $file[ 'name' ] );
                    echo '<div>Файл "' . $file[ 'name' ] . '" успешно загружен!</div>';

                }
            }
        }
    }
} else {
    echo "Файл не выбран";
}
