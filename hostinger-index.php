<?php

/*
|--------------------------------------------------------------------------
| Hostinger-specific Laravel Bootstrap
|--------------------------------------------------------------------------
|
| This file is specifically designed for Hostinger hosting where the
| document root cannot be changed to the public directory.
|
*/

// Define the public path for Laravel
define('LARAVEL_START', microtime(true));

// Register the Composer autoloader
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);