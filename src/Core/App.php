<?php

class App
{
    static public function load(stdClass $object): void
    {
        $controller = new ReflectionClass($object->controller);
        $instance = $controller->newInstanceArgs();
        $action = $object->action;
        $instance->$action($object->path);
    }
}