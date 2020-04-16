<?php

namespace Error;

/**
 * Class Debugger
 * Holds error messages, which will output at the end.
 *
 * @package Error
 */
class Debugger
{
    /**
     * @var string $dumps
     */
    private static $dumps = 'Debug:<br>';

    /**
     * Adds $var with a newline to {@link Debugger::$dumps}.
     *
     * @param $var
     */
    public static function dump($var)
    {
        self::$dumps .= "$var<br>";
    }

    /**
     * @return string $dumps
     */
    public static function getDumps()
    {
        return self::$dumps . '----------------------------------------<br>';
    }
}