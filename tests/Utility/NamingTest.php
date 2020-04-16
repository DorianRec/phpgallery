<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Utility\Naming;

final class NamingTest extends TestCase
{
    /**
     * Tests for {@link Naming::lowerToUpper()}
     * @test
     */
    public static function lowerToUpperTest1()
    {
        self::assertEquals('viewAll', Naming::lowerToUpper('view_all'));
        self::assertEquals('viewAllPages', Naming::lowerToUpper('view_all_pages'));
        self::assertEquals('loadURL', Naming::lowerToUpper('load_u_r_l'));
    }

    /**
     * Tests for P@link Naming::upperToLower()}
     *
     * @test
     */
    public static function upperToLowerTest1()
    {
        self::assertEquals('view_all_pages', Naming::upperToLower('viewAllPages'));
        self::assertEquals('view_all', Naming::upperToLower('viewAll'));
        self::assertEquals('load_u_r', Naming::upperToLower('loadUR'));
        self::assertEquals('load_u_r_l', Naming::upperToLower('loadURL'));
    }
}