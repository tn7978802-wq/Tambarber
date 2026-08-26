<?php

return [

    'default' => env('FILESYSTEM_DISK', 'public'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        // Disk "public" dùng để lưu ảnh do người dùng tải lên (kiểu tóc, dịch vụ,
        // barber, trạng thái/sự kiện...). Cần chạy `php artisan storage:link`
        // một lần để symlink public/storage -> storage/app/public.
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
