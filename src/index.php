<?php declare(strict_types=1);

use Core\App;
use Routing\Router;
use View\Helper\UrlHelper;

require_once __DIR__ . '/autoload.php';

include __DIR__ . '/../config/app.php';
include __DIR__ . '/../config/routes.php';

App::load(
    Router::pathToCombo(
        UrlHelper::get_url()));