<?php

namespace Core;

class Configure
{
    /**
     * @var bool $debug tells, whether debug output should be printed.
     */
    public static $debug = false;

    public static function read(string $var)
    {
        return self::$$var;
    }

    public static function set(string $var, bool $value)
    {
        self::$$var = $value;
    }
}