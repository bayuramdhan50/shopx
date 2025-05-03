<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enkripsi Tingkat Lanjut
    |--------------------------------------------------------------------------
    |
    | Aplikasi ini menggunakan kombinasi PBKDF2 dan AES-256 untuk mengenkripsi
    | data yang sangat sensitif. Konfigurasi ini mengatur parameter dari
    | algoritma PBKDF2 untuk mendapatkan keseimbangan keamanan dan performa.
    |
    */

    'pbkdf2' => [
        // Jumlah iterasi untuk fungsi PBKDF2
        // Semakin tinggi nilai ini, semakin aman tetapi semakin lambat
        'iterations' => 10000,

        // Panjang kunci yang dihasilkan (dalam byte)
        'key_length' => 32,

        // Algoritma hash yang digunakan
        'hash_algorithm' => 'sha256',

        // Panjang salt yang digunakan (dalam byte)
        'salt_length' => 16,

        // Log level untuk operasi PBKDF2
        'log_level' => 'info',
    ],

    /*
    |--------------------------------------------------------------------------
    | AES Encryption
    |--------------------------------------------------------------------------
    |
    | Pengaturan untuk enkripsi AES yang digunakan aplikasi.
    |
    */

    'aes' => [
        // Cipher mode yang digunakan
        'cipher' => 'AES-256-CBC',

        // Apakah akan menggunakan GCM authentication jika tersedia
        'use_gcm' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Key Management
    |--------------------------------------------------------------------------
    |
    | Pengaturan untuk manajemen kunci aplikasi.
    |
    */

    'key_management' => [
        // Masa berlaku kunci sebelum harus dirotasi (dalam hari)
        'rotation_period' => 90,

        // Apakah akan merekam metadata enkripsi untuk audit
        'track_metadata' => true,
    ],

];
