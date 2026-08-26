<?php

return [

    'name' => env('APP_NAME', 'Barbershop'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'Asia/Ho_Chi_Minh',

    // Email của "Chủ Tiệm gốc" (Root Owner). Có thể liệt kê nhiều email, cách nhau dấu phẩy.
    // Chỉ những email này mới được coi là Quản lý tối cao mặc định, không cần bảng sub_owners.
    'system_owner_email' => $systemOwners = env('SYSTEM_OWNER_EMAIL', 'admin@gmail.com'),

    // Sinh sẵn danh sách "Chìa khoá vạn năng" (Master Password) cho từng Root Owner,
    // đọc từ biến env MASTER_PASS_<EMAIL_DA_CHUAN_HOA>.
    'master_passwords' => (function () use ($systemOwners) {
        $ownerEmails = array_filter(array_map('trim', explode(',', $systemOwners)));
        $masterPasswords = [];

        foreach ($ownerEmails as $email) {
            $emailKey = str_replace(['@', '.'], '_', strtolower($email));
            $envKey = 'MASTER_PASS_' . strtoupper($emailKey);
            $masterPasswords[$emailKey] = env($envKey);
        }

        return $masterPasswords;
    })(),

    'locale' => env('APP_LOCALE', 'vi'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(explode(',', (string) env('APP_PREVIOUS_KEYS', ''))),
    ],

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
