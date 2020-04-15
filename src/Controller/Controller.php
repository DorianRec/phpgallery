<?php declare(strict_types=1);

namespace Controller;

use Core\App;

/**
 * Class Controller
 * Controllers are building up arbitrary pages.
 *
 * @package Controller
 */
abstract class Controller
{
    /**
     * TODO accept paths
     *
     * Loads a page given by $path
     *
     * @param array $path of the form [
     *  'controller' => string,
     *  'action' => string,
     *  'args' => string
     * ]
     */
    public static function redirect(array $path): void
    {
        if (gettype($path) == 'array') {
            $path['args'] = [];
            App::load($path);
            return;
        }
    }
}
