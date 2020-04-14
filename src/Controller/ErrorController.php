<?php

class ErrorController extends Controller
{
    static public function error(array $pathFragments)
    {
        print_r($pathFragments);
        require_once __DIR__ . '/../../templates/error.php';
    }
}
