<?php

class Controller
{
    static public function view(object $pathFragments)
    {
        $CONTROLLER['active'] = 'home';
        require_once __DIR__ . '/../../templates/page.php';
    }

    static public function error(object $pathFragments)
    {
        print_r($pathFragments);
        require_once __DIR__ . '/../../templates/error.php';
    }
}
