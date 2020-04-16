<?php declare(strict_types=1);

namespace Controller;

class PagesController extends Controller
{
    static public function home(array $pathFraments)
    {
        if ($pathFragments == []) {
            $CONTROLLER['controller'] = __CLASS__;
            $CONTROLLER['action'] = __FUNCTION__;
        } else {
            ErrorController::error('404 Page not found!');
        }
        require_once __DIR__ . '/../../templates/page.php';
    }

    static public function current(array $pathFraments)
    {
        return;
    }

    static public function aboutUs(array $pathFraments)
    {
        return;
    }

    static public function view(array $pathFragments)
    {
        return;
    }
}
