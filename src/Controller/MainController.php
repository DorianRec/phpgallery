<?php

class MainController
{
    static public function view(array $pathFragments)
    {
        $CONTROLLER['active'] = 'home';
        require_once __DIR__ . '/../../templates/page.php';
    }
}
