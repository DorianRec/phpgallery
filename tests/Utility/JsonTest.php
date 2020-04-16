<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Utility\Json;

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

    /**
     * Tests for {@link Json::arrayToStdClass()}
     *
     * @test
     */
    public function arrayToStdClassTest1(): void
    {
        $arrayToStdClass = Json::arrayToStdClass(self::$array);
        $stdClass = json_decode(self::$json);
        self::assertTrue($stdClass == $arrayToStdClass, '$stdClass != $arrayToStdClass' . "\n" .
            '$arrayToStdClass: ' . print_r($arrayToStdClass) . "\n" .
            '$stdClass: ' . print_r($stdClass));
    }

    /**
     * Tests for {@link Json::stdClassToArray()}
     *
     * @test
     */
    public function stdClassToArrayTest1(): void
    {
        $stdClassToArray = Json::stdClassToArray(json_decode(self::$json));
        self::assertTrue(
            array_diff(self::$array, $stdClassToArray) == [], '$array != $stdClassToArray' . "\n" .
            '$array: ' . print_r(self::$array) . "\n" .
            '$stdClassToArray: ' . print_r($stdClassToArray));
    }
}