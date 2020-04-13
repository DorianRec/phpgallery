<?php

class Json
{
    /**
     * Converts and array into a stdClass.
     *
     * @param array $array which will convert to stdClass
     * @return stdClass the converted $array
     */
    static public function array_to_stdclass(array $array): stdClass
    {
        $stdClass = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = self::array_to_stdclass($value);
            }
            $stdClass->$key = $value;
        }
        return $stdClass;
    }
}
