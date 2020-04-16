<?php

namespace Utility;

class Naming
{
    public static function lowerActionToUpper(string $lower): string
    {
        return preg_replace_callback('/\_[a-z]/', function ($chars) {
            return strtoupper("{$chars[0][1]}");
        }, $lower);
    }

    public static function upperActionToLower(string $upper): string
    {
        $upper = preg_replace_callback('/^[A-Z]/', function ($chars) {
            print_r($chars);
            return strtolower("{$chars[0][0]}");
        }, $upper);
        return preg_replace_callback('/[A-Z]/', function ($chars) {
            print_r($chars);
            return strtolower("_{$chars[0][0]}");
        }, $upper);
    }
}