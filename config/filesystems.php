<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        // BARU: disk khusus untuk file media (foto komoditi, dst) via Spatie MediaLibrary.
        // Defaultnya folder public/media bawaan Laravel (lokal/dev). Di cPanel (struktur
        // ~/app + ~/public_html terpisah), isi MEDIA_DISK_ROOT & MEDIA_DISK_URL di .env
        // supaya file langsung tersimpan di public_html - TANPA symlink storage:link
        // (lebih aman daripada override public_path() di bootstrap/app.php, karena env()
        // di bootstrap/app.php belum bisa baca file .env pada tahap itu).
        // Sengaja pakai `?:` (bukan argumen default di env()) - kalau MEDIA_DISK_ROOT ada
        // di .env tapi dikosongkan (""), env() TETAP mengembalikan string kosong itu (bukan
        // otomatis jatuh ke default), jadi harus dicek manual supaya tidak salah nulis ke ".".
        'media' => [
            'driver' => 'local',
            'root' => env('MEDIA_DISK_ROOT') ?: public_path('media'),
            'url' => rtrim(env('MEDIA_DISK_URL') ?: rtrim(env('APP_URL', 'http://localhost'), '/').'/media', '/'),
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
