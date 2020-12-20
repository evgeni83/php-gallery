<?php

function get_limits(): array {
    return [
        'min_file_size' => 0,
        'max_file_size' => 5242880,
        'file_types'    => [
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
