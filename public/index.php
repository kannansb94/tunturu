<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Hotfix for XAMPP subdirectory deployment
// When accessing via /tunturu/ instead of /tunturu/public/, Laravel gets confused.
// We strip the /tunturu prefix so Laravel thinks it's running at root.
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/tunturu/') === 0 && strpos($_SERVER['REQUEST_URI'], '/tunturu/public/') === false) {
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], 8); // Length of /tunturu
}

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());
