<?php declare(strict_types=1);

namespace Utility;

use stdClass;

/**
 * Class Json
 *
 * contains utility functions for handling json.
 * @package Utility
 */
class Json
{
    /**
     * Converts an array into a stdClass.
     *
     * @param array $array which will convert to a stdClass
     * @return stdClass the converted $array
     */
    static public function arrayToStdClass(array $array): stdClass
    {
        $stdClass = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = self::arrayToStdClass($value);
            }
            $stdClass->$key = $value;
        }
        return $stdClass;
    }

    /**
     * Converts a stdClass into an array.
     *
     * @param stdClass $stdClass which will convert to an array
     * @return stdClass the converted $array
     */
    static public function stdClassToArray(stdClass $stdClass): array
    {
        $array = [];
        foreach ($stdClass as $key => $value) {
            if (is_object($value)) {
                $value = self::stdClassToArray($value);
            }
            $array[$key] = $value;
        }
        return $array;
    }
}
