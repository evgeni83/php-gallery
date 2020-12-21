<?php

function get_limits(): array {
    return [
        'max_files_amount' => 5,
        'max_file_size'    => 5242880,
        'file_types'       => [
            "image/jpeg",
            "image/jpg",
            "image/png"
        ]
    ];
}

function get_upload_path(): string {
    return $_SERVER[ 'DOCUMENT_ROOT' ] . '/upload/';
}

function get_url( $path = '' ): string {
    return sprintf(
        "%s://%s%s",
        isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] != 'off' ? 'https' : 'http',
        $_SERVER[ 'SERVER_NAME' ],
        $path
    );
}

function restructure_files_array( $files ): array {
    $my_files_arr = array();
    $my_files_count = count( $files[ 'name' ] );
    $my_files_keys = array_keys( $files );

    for ( $i = 0; $i < $my_files_count; $i++ ) {
        foreach ( $my_files_keys as $key ) {
            $my_files_arr[ $i ][ $key ] = $files[ $key ][ $i ];
        }
    }
    return $my_files_arr;
}
