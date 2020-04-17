<?php declare(strict_types=1);

use Core\App;
use Routing\Router;

require_once __DIR__ . '/autoload.php';

include __DIR__ . '/../config/app.php';
include __DIR__ . '/../config/routes.php';

App::load(
    Router::resolve(
        ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")
    ));
