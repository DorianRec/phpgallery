<?php declare(strict_types=1);

class MainController
{
    static public function view(array $pathFragments)
    {
        if ($pathFragments == []) {
            $CONTROLLER['controller'] = 'Main';
            $CONTROLLER['action'] = 'view';
        } else {
            return Controller::redirect(['controller' => 'Error', 'action' => 'error']);
        }
        require_once __DIR__ . '/../../templates/page.php';
    }
}
