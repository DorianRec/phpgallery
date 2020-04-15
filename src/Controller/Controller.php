<?php declare(strict_types=1);

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
    public static function redirect(array $path)
    {
        if (gettype($path) == 'array') {
            $path['args'] = [];
            return App::load($path);
        }
    }
}
