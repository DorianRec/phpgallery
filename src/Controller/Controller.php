<?php

class Controller
{
    static public function view(array $pathFragments)
    {
        require_once __DIR__ . '/../../templates/page.php';
    }

    static public function error(array $pathFragments)
    {
        print_r($pathFragments);
        require_once __DIR__ . '/../../templates/error.php';
    }
}