<?php declare(strict_types=1);

namespace Controller;

use Core\Configure;
use Error\Debugger;

class ErrorController extends Controller
{

    /**
     * This generates an arbitrary error page.
     *
     * @param string $message the error message
     */
    static public function error(string $message): void
    {
        if (Configure::read('debug'))
            echo Debugger::getDumps();
        echo $message;
        exit();
    }
}
