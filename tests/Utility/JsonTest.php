<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class JsonTest extends TestCase
{
    public static $array = [
        'key' => 'outerValue',
        'int' => 42,
        'array' => [
            'key' => 'innerValue',
            'array' => [
                'key' => 'innerInnerValue'
            ]
        ]
    ];

    public static $json = "{
        \"key\": \"outerValue\",
        \"int\": 42,
        \"array\": {
            \"key\": \"innerValue\",
            \"array\": {
                \"key\": \"innerInnerValue\"
            }
        }
    }";

    /** @test */
    public function array_to_stdclass_test1(): void
    {
        $array_to_stdclass = Json::array_to_stdclass(self::$array);
        //print_r($array_to_stdclass);
        $stdClass = json_decode(self::$json);
        //print_r($stdClass);
        self::assertTrue($stdClass == $array_to_stdclass, '$stdClass != $array_to_stdclass' . "\n" .
            '$array_to_stdclass: ' . print_r($array_to_stdclass) . "\n" .
            '$stdClass: ' . print_r($stdClass));
    }

    /** @test */
    public function stdclass_to_array_test1(): void
    {
        $stdClass_to_array = Json::stdClass_to_array(json_decode(self::$json));
        print_r($stdClass_to_array);
        self::assertTrue(
            array_diff(self::$array, $stdClass_to_array) == [], '$array != $stdClass_to_array' . "\n" .
            '$array: ' . print_r(self::$array) . "\n" .
            '$stdClass_to_array: ' . print_r($stdClass_to_array));
    }
}