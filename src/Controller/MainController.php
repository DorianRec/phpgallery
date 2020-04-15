<?php declare(strict_types=1);

namespace Controller;

class MainController extends Controller
{
    static public function view(array $pathFragments)
    {
        if ($pathFragments == []) {
            $CONTROLLER['controller'] = 'Main';
            $CONTROLLER['action'] = 'view';
        } else {
            ErrorController::error('404 Page not found!');
        }
        require_once __DIR__ . '/../../templates/page.php';
    }
}
