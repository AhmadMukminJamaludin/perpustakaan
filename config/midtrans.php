<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Server Key
    |--------------------------------------------------------------------------
    |
    | Masukkan server key Midtrans Anda di sini. Nilai default diambil dari
    | variabel lingkungan MIDTRANS_SERVER_KEY.
    |
    */
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Client Key
    |--------------------------------------------------------------------------
    |
    | Masukkan client key Midtrans Anda di sini. Nilai default diambil dari
    | variabel lingkungan MIDTRANS_CLIENT_KEY.
    |
    */
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Production Mode
    |--------------------------------------------------------------------------
    |
    | Ubah ke true jika Anda ingin menggunakan Midtrans dalam mode production.
    | Secara default, nilainya diambil dari variabel lingkungan MIDTRANS_IS_PRODUCTION.
    |
    */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitized Request Data
    |--------------------------------------------------------------------------
    |
    | Jika true, Midtrans akan melakukan sanitasi pada data request yang dikirim.
    |
    */
    'is_sanitized' => true,

    /*
    |--------------------------------------------------------------------------
    | 3D Secure Transaction
    |--------------------------------------------------------------------------
    |
    | Jika true, transaksi menggunakan 3D Secure.
    |
    */
    'is_3ds' => true,
];
