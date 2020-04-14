<?php declare(strict_types=1);
/*
 * Make every class available.
 */
spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . '/../Controller/' . $class . '.php'))
        include __DIR__ . '/../Controller/' . $class . '.php';
    else if (file_exists(__DIR__ . '/../Model/Entity/' . $class . '.php'))
        include __DIR__ . '/../Model/Entity/' . $class . '.php';
    else if (file_exists(__DIR__ . '/../View/' . $class . '.php'))
        include __DIR__ . '/../View/' . $class . '.php';
    else if (file_exists(__DIR__ . '/../View/Helper/' . $class . '.php'))
        include __DIR__ . '/../View/Helper/' . $class . '.php';
    else if (file_exists(__DIR__ . '/../Routing/' . $class . '.php'))
        include __DIR__ . '/../Routing/' . $class . '.php';
    else if (file_exists(__DIR__ . '/../Utility/' . $class . '.php'))
        include __DIR__ . '/../Utility/' . $class . '.php';
    else if (file_exists(__DIR__ . '/../Core/' . $class . '.php'))
        include __DIR__ . '/../Core/' . $class . '.php';
});
