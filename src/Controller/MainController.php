<?php declare(strict_types=1);

class MainController
{
    static public function view(array $pathFragments)
    {
        $CONTROLLER['controller'] = 'Main';
        $CONTROLLER['action'] = 'view';
        require_once __DIR__ . '/../../templates/page.php';
    }
}
