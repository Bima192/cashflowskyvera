<?php

// Vercel Serverless: Create storage directories in /tmp
if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    $storage = '/tmp/storage';
    $dirs = [
        $storage . '/app',
        $storage . '/framework/cache/data',
        $storage . '/framework/sessions',
        $storage . '/framework/views',
        $storage . '/logs'
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}

require __DIR__ . '/../public/index.php';
