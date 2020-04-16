<?php declare(strict_types=1);

use Core\App;
use Routing\Router;
use View\Helper\UrlHelper;

require_once __DIR__ . '/autoload.php';

// TODO move into tests
/*
$router = new Router();
$router->connect('/', '1::1');
$router->connect('/a', '2::2');
$router->connect('/a/b', '3::3');
$router->connect('/a/*', '4::4');
$router->connect('/a/**', '5::5');
*/

include __DIR__ . '/../config/routes.php';
print_r(Router::$tree);

App::load(
    Router::urlToCombo(
        UrlHelper::get_url()));