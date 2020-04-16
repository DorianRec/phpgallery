<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Utility\Naming;

final class NamingTest extends TestCase
{
    /**
     * Tests for {@link Naming::lowerActionToUpper()}
     * @test
     */
    public static function lowerActionToUpperTest1()
    {
        self::assertEquals('viewAll', Naming::lowerActionToUpper('view_all'));
        self::assertEquals('viewAllPages', Naming::lowerActionToUpper('view_all_pages'));
        self::assertEquals('loadURL', Naming::lowerActionToUpper('load_u_r_l'));
        self::assertEquals('sWT', Naming::lowerActionToUpper('s_w_t'));
        self::assertEquals('_Construct', Naming::lowerActionToUpper('__construct')); // invalid
        self::assertEquals('__DIR__', Naming::lowerActionToUpper('__DIR__')); // invalid
    }

    /**
     * Tests for P@link Naming::upperActionToLower()}
     *
     * @test
     */
    public static function upperActionToLowerTest1()
    {
        self::assertEquals('view_all_pages', Naming::upperActionToLower('viewAllPages'));
        self::assertEquals('view_all', Naming::upperActionToLower('viewAll'));
        self::assertEquals('load_u_r', Naming::upperActionToLower('loadUR'));
        self::assertEquals('load_u_r_l', Naming::upperActionToLower('loadURL'));
        self::assertEquals('s_w_t', Naming::upperActionToLower('SWT')); // invalid
    }
}