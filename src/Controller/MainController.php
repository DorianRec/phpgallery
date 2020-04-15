<?php declare(strict_types=1);

class MainController
{
    static public function view(array $pathFragments)
    {
        if ($pathFragments == []) {
            $CONTROLLER['controller'] = 'Main';
            $CONTROLLER['action'] = 'view';
        } else {
            echo 'error';
            return;
        }
        require_once __DIR__ . '/../../templates/page.php';
    }
}
