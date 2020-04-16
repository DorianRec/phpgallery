<?php declare(strict_types=1);

namespace Core;

use Controller\Controller;
use Controller\ControllerFactory;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

/**
 * Class App
 * contain core features for this application.
 *
 * @package Core
 */
class App
{
    /**
     * This instantiates a new Controller of type $object['controller']
     * and calls its method $object['action'] with arguments $object['args'].
     *
     * @param array $object of the form [
     *  'controller' => string,
     *  'action' => string,
     *  'args' => string
     * ]
     * @throws ReflectionException if $object['controller'] does not describe an existing type of controller.
     * @deprecated Not longer usable, since autoload only asks for the
     * Classname instead of giving the whole "use" path.
     */
    static public function loadOld(array $object)
    {
        try {
            $controller = new ReflectionClass($object['controller'] . 'Controller');
            $instance = $controller->newInstanceArgs();
            $action = $object['action'];
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException("\"{$object['$controller']}\" describes no type of controller.");
        }
        $instance->$action($object['args']);
    }

    /**
     * This instantiates a new Controller of type $object['controller']
     * and calls its method $object['action'] with arguments $object['args'].
     *
     * @param array $object of the form [
     *  'controller' => string,
     *  'action' => string,
     *  'args' => string
     * ]
     */
    static public function load(array $object): void
    {
        if ($controller = ControllerFactory::build($object['controller'])) {
            $action = $object['action'];
            $controller->$action($object['args']);
        } else {
            Controller::error('Page not found!');
        }
    }
}
