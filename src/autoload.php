<?php declare(strict_types=1);
/*
 * Make every class available.
 */
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    include $class . '.php';
});
