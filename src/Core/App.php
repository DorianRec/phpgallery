<?php declare(strict_types=1);

class App
{
    static public function load(stdClass $object): void
    {
        $controller = new ReflectionClass($object->controller . 'Controller');
        $instance = $controller->newInstanceArgs();
        $action = $object->action;
        $instance->$action($object->args);
    }
}
