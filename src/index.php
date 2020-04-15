<?php declare(strict_types=1);

use Core\App;
use Routing\Router;
use View\Helper\UrlHelper;

require_once __DIR__ . '/autoload.php';

App::load(
    Router::findLastSetup(
        UrlHelper::get_url()));