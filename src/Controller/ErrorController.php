<?php declare(strict_types=1);

namespace Controller;

class ErrorController extends Controller
{
    static public function error(array $pathFragments)
    {
        require_once __DIR__ . '/../../templates/error.php';
    }
}
