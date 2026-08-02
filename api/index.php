<?php

// Prepare temporary storage directories for Vercel serverless environment
$tmpDirs = [
    '/tmp/views',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Redirect Laravel caches and compiled views to /tmp (writable in Vercel)
$_ENV['APP_STORAGE'] = '/tmp';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';

// Forward request to Laravel public index entrypoint
require __DIR__ . '/../public/index.php';
