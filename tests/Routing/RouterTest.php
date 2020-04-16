<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Routing\Router;

final class RouterTest extends TestCase
{

    /**
     * Tests for {@link Router::fixPath()}.
     * Tests, whether the backslashes are replaced by slashes.
     *
     * @test
     */
    public function fixPathTest1(): void
    {
        $this->assertEquals(
            '/a/b/c/',
            Router::fixPath('\\a\\b\\c\\')
        );
    }

    /**
     * Tests for {@link Router::fixPath()}.
     * Tests whether multiple consequtive '///' are shrinked to a single one.
     *
     * @test
     */
    public function fixPathTest2(): void
    {
        $this->assertEquals(
            '/a/b/',
            Router::fixPath('/a/////b/')
        );
    }

    /**
     * Tests for {@link Router::fixPath()}.
     * Tests, whether slashes are appended at the start and the end of the string, if there are none.
     *
     * @test
     */
    public function fitPathMissingTest1(): void
    {
        $this->assertEquals(
            '/a/b/',
            Router::fixPath('a/b')
        );
        $this->assertEquals(
            '/a/b/',
            Router::fixPath('/a/b')
        );
        $this->assertEquals(
            '/a/b/',
            Router::fixPath('a/b/')
        );
    }

    /**
     * Tests for {@link Router::fixPath()}.
     * Tests, whether something weird happens on a base path.
     *
     * @test
     */
    public function fixPathSlashTest1(): void
    {
        $this->assertEquals(
            '/',
            Router::fixPath('/')
        );
    }

    /**
     * Tests for {@link Router::fixPath()}.
     * Tests, whether multiple backslashes and slashes are shrinked to a single slash.
     *
     * @test
     */
    public function fixPathCombinationTest1(): void
    {
        $this->assertEquals(
            '/a/b/',
            Router::fixPath('/a///\\\\\\b/')
        );
    }

    /**
     * Tests for {@link Router::fixPath()}.
     * In this cases, '.' will be removed
     *
     * @test
     */
    public function fixPathDotTest1()
    {
        $this->assertEquals(
            '/a/b/',
            Router::fixPath('/a/./b/')
        );
        $this->assertEquals(
            '/',
            Router::fixPath('/.')
        );
    }

    /**
     * Tests for {@link Router::fixPath()}.
     * In this cases, '..' will be removed
     *
     * @test
     */
    public function fixPathDotsTest1()
    {
        $this->assertEquals(
            '/a/b/d/e/',
            Router::fixPath('/a/b/c/../d/e/')
        );
        $this->assertEquals(
            '/d/e/',
            Router::fixPath('/a/b/../../d/e/')
        );
        $this->assertEquals(
            '/a/b/',
            Router::fixPath('/../a/b/')
        );
        $this->assertEquals(
            '/a/b/e/',
            Router::fixPath('/a/b/c/d/../../e/')
        );
    }

    private static function compareCombos($expected, $actual): void
    {
        self::assertEquals($expected['controller'], $actual['controller'],
            "Expected controller to equal {$expected['controller']}, but was {$actual['controller']}!");
        self::assertEquals($expected['action'], $actual['action'],
            "Expected action to equal {$expected['action']}, but was {$actual['action']}!");
    }

    private static function compareURLs($expected, $actual): void
    {
        self::assertEquals($expected, $actual,
            "Expected URL to equal $expected, but was $actual!");
    }

    /**
     * @test
     */
    public static function fixPathTest3()
    {
        self::assertEquals('/', Router::fixPath('/../../../'));
    }
}