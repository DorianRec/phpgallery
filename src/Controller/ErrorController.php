<?php declare(strict_types=1);

namespace Controller;

class ErrorController extends Controller
{

    /**
     * This generates an arbitrary error page.
     *
     * @param string $message the error message
     */
    static public function error(array $message): void
    {
        echo $message;
        exit();
    }
}
