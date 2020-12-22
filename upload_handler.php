<?php

if ( empty( $_FILES ) ) {
    $response[] = 'Файл не выбран';
    exit( json_encode( $response, JSON_FORCE_OBJECT ) );
}

require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/helper.php';
$limits = get_limits();

if ( count( $_FILES[ 'name' ] ) > $limits['max_files_amount'] ) {
    $response[] = 'Ошибка! Разрешается выбрать не более ' . $limits['max_files_amount'] . ' файлов';
    exit( json_encode( $response, JSON_FORCE_OBJECT ) );
}

$upload_path = get_upload_path();
$response = [];
$files = restructure_files_array( $_FILES[ 'myFile' ] );

foreach ( $files as $key => $file ) {

    if ( $file[ 'error' ] > 0 ) {
        $response[ $key ] = '<div>Ошибка</div>';
        continue;
    }

    if ( !( in_array( $file[ "type" ], $limits[ 'file_types' ] ) ) ) {
        $message_html = '<div>Ошибка! Формат файла "' . $file[ 'name' ] . '" должен быть ';
        foreach ( $limits[ 'file_types' ] as $key => $file_type ) {
            $file_type = str_replace( 'image/', '', $file_type );
            if ( $key < count( $limits[ 'file_types' ] ) - 1 ) {
                $message_html .= $file_type . ', или ';
            } else {
                $message_html .= $file_type;
            }
        }
        $message_html .= '</div>';
        $response[ $key ] = $message_html;
        continue;
    }

    if ( $file[ 'size' ] > $limits[ 'max_file_size' ] ) {
        $message_html = '<div>Ошибка! Размер файла "' . $file[ 'name' ] . '" равен ';
        $message_html .= get_file_size($file['tmp_name']);
        $message_html .= ' Размер не должен превышать ';
        $message_html .= round( $limits[ 'max_file_size' ] / ( 1024 ** 2 ), 2 );
        $message_html .= ' МБайт</div>';
        $response[ $key ] = $message_html;
        continue;
    }

    move_uploaded_file( $file[ 'tmp_name' ], $upload_path . $file[ 'name' ] );
    $response[ $key ] = '<div>Файл "' . $file[ 'name' ] . '" успешно загружен!</div>';

}

echo json_encode( $response, JSON_FORCE_OBJECT );
