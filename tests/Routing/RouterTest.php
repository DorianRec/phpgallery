<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Routing\Router;
use Utility\Json;
use function PHPUnit\Framework\assertFalse;

final class RouterTest extends TestCase
{
    static public $json = "{
  \"content\": 0,
  \"subtree\": {
    \"home\": {
      \"content\": 1,
      \"subtree\": {}
    },
    \"page\": {
      \"content\": 2,
      \"subtree\": {}
    },
    \"overpage123\": {
      \"content\": 3,
      \"subtree\": {
        \"footer\": {
          \"content\": 4,
          \"subtree\": {
            \"lower\": {
              \"content\": 5,
              \"subtree\": {}
            }
          }
        },
        \"sunderpage\": {
          \"content\": 6,
          \"subtree\": {}
        }
      }
    }
  }
}";

    static public $special2 = [
        "title" => "root",
        "content" => 0,
        "subtree" => array(
            "example.de" => array(
                "title" => "example-page",
                "content" => 42,
                "subtree" => array()
            ),
            "localhost" => array(
                "title" => "Home is where the heart is.",
                "content" => 666,
                "subtree" => array())
        ,
            "127.0.0.1" => array(
                "title" => "Home is where the heart is.",
                "content" => 666,
                "subtree" => array()
            ))
    ];

    /**
     * Tests for {@link Router::connect()}
     *
     * @test
     */
    public function connectBasicTest1()
    {
        $expected = [
            'controller' => '1',
            'action' => '2',
            'a' => [
                'controller' => '9',
                'action' => '10',
                'b' => [
                    'controller' => '5',
                    'action' => '6',
                ]
            ]
        ];

        $router = new Router();
        $router->connect('/', '1::2');
        $router->connect('/a', '3::4');
        $router->connect('/a/b', '5::6');
        $router->connect('/a/*', '7::8');
        $router->connect('/a/**', '9::10');

        $actual = Json::stdClassToArray($router::$tree);

        self::assertTrue(
            array_diff($expected, $actual) == [], '$expected != $actual' . "\n" .
            '$expected: ' . print_r($expected) . "\n" .
            '$actual: ' . print_r($actual));
    }

    /**
     * Tests for {@link Router::connect()}
     *
     * @test
     */
    public function connectLocationsTest1()
    {
        $json = "{
  \"controller\": \"Main\",
  \"action\": \"home\",
  \"subtree\": {
    \"gallery\": {
      \"controller\": \"Gallery\",
      \"action\": \"view\",
      \"subtree\": {}
    },
    \"page\": {
      \"controller\": \"Main\",
      \"action\": \"view\",
      \"subtree\": {}
    },
    \"css\": {
      \"controller\": \"File\",
      \"action\": \"css\",
      \"subtree\": {}
    },
    \"html\": {
      \"controller\": \"File\",
      \"action\": \"html\",
      \"subtree\": {}
    },
    \"img\": {
      \"controller\": \"File\",
      \"action\": \"img\",
      \"subtree\": {}
    },
    \"js\": {
      \"controller\": \"File\",
      \"action\": \"js\",
      \"subtree\": {}
    },
    \"txt\": {
      \"controller\": \"File\",
      \"action\": \"txt\",
      \"subtree\": {}
    }
  }
}";
        Router::$tree = null;
        Router::connect('/', ['controller' => 'Main', 'action' => 'home']);
        Router::connect('/gallery', ['controller' => 'Gallery', 'action' => 'view']);
        Router::connect('/page', ['controller' => 'Main', 'action' => 'view']);
        Router::connect('/css', ['controller' => 'File', 'action' => 'css']);
        Router::connect('/html', ['controller' => 'File', 'action' => 'html']);
        Router::connect('/img', ['controller' => 'File', 'action' => 'img']);
        Router::connect('/js', ['controller' => 'File', 'action' => 'js']);
        Router::connect('/txt', ['controller' => 'File', 'action' => 'txt']);
        self::assertTrue(Router::$tree == json_decode($json), 'Router::$tree != json_decode($json)' . "\n" .
            'Router::$tree: ' . print_r(Router::$tree) . "\n" .
            'json_decode($json): ' . print_r(json_decode($json)));
    }

    /**
     * Tests for {@link Router::pathToCombo()}.
     *
     * @test
     */
    public function findLastSetupTest1()
    {
        Router::$tree = null;
        Router::connect('/', ['controller' => 'Main', 'action' => 'home']);
        Router::connect('/gallery', ['controller' => 'Gallery', 'action' => 'view']);
        Router::connect('/page', ['controller' => 'Main', 'action' => 'view']);
        Router::connect('/css', ['controller' => 'File', 'action' => 'css']);
        Router::connect('/html', ['controller' => 'File', 'action' => 'html']);
        Router::connect('/img', ['controller' => 'File', 'action' => 'img']);
        Router::connect('/js', ['controller' => 'File', 'action' => 'js']);
        Router::connect('/txt', ['controller' => 'File', 'action' => 'txt']);

        self::compareCombos(Router::pathToCombo('/gallery'), ['controller' => 'Gallery', 'action' => 'view']);
    }

    /**
     * Test for {@link Router::pathToCombo()}.
     * Here we test, whether we get the home page.
     *
     * @test
     */
    public function urlToComboHttpTest1(): void
    {
        $expected = ['controller' => "0", 'action' => "1"];

        Router::$tree = null;
        Router::connect('/', $expected);
        self::compareCombos($expected,
            Router::pathToCombo('/'));
    }

    /**
     * Test for {@link Router::treeSearch()}.
     * In this test, the function should answer with the error-page.
     *
     * @test
     */
    public function parseErrorTest1(): void
    {
        Router::$tree = null;
        assertFalse(Router::pathToCombo('/f7fiyfifuiy'));
        assertFalse(Router::pathToCombo('/notexisting/alsonotexisting'));
    }

    /**
     * Test for {@link Router::pathToCombo()}.
     * Here we test the function with simple paths.
     *
     * @test
     */
    public function urlToComboSimpleTest1(): void
    {
        Router::$tree = null;
        $wrong = ['controller' => 'Wrong', 'action' => 'way'];
        $home = ['controller' => 'Main', 'action' => 'home'];
        $page = ['controller' => 'Pages', 'action' => 'view'];
        $overpage = ['controller' => 'Over', 'action' => 'upper'];

        Router::connect('/', $wrong);
        Router::connect('/home', $home);
        Router::connect('/page', $page);
        Router::connect('/overpage123', $overpage);

        self::compareCombos(Router::pathToCombo('/home/'), $home);
        self::compareCombos(Router::pathToCombo('/page/'), $page);
        self::compareCombos(Router::pathToCombo('/overpage123/'), $overpage);
    }

    /**
     * Test for {@link Router::pathToCombo()}.
     * Here we test whether the function is able to dive into deep path trees.
     *
     * @test
     */
    public function urlToComboComplexTest1(): void
    {
        $wrong = ['controller' => 'WrongWay', 'action' => 'wrongWay'];
        $expected1 = ['controller' => '1', 'action' => '2'];
        $expected2 = ['controller' => '3', 'action' => '4'];
        $expected3 = ['controller' => '5', 'action' => '6'];

        Router::$tree = null;
        Router::connect('/', $wrong);
        Router::connect('/overpage123/footer', $expected1);
        Router::connect('/overpage123/footer/lower', $expected2);
        Router::connect('/overpage123/sunderpage', $expected3);
        self::compareCombos($expected1, Router::pathToCombo('http://example.de/overpage123/footer/'));
        self::compareCombos($expected2, Router::pathToCombo('http://example.de/overpage123/footer/lower/'));
        self::compareCombos($expected3, Router::pathToCombo('http://example.de/overpage123/sunderpage/'));
    }

    /**
     * Test for {@link Router::pathToCombo()}.
     * In this test, we test whether the function differs between upper and lower caps.
     *
     * @test
     */
    public function urlToComboCapsTest1(): void
    {
        $expected = ['controller' => 'Footer', 'action' => 'lower'];

        Router::$tree = null;
        Router::connect('/overpage123', $expected);

        self::compareCombos($expected, Router::pathToCombo('/overpage123/footer/lower'));
        self::compareCombos($expected, Router::pathToCombo('/OVERPAGE123/FOOTER/LOWER'));
        self::compareCombos($expected, Router::pathToCombo('/OvErPaGe123/FoOtEr/LoWeR'));
    }

    /** @test */
    public function urlToComboCapsTest2(): void
    {
        $wrong = ['controller' => 'Wrong', 'action' => 'way'];
        $expected = ['controller' => 'MathEngine', 'action' => 'calculateSquareRoot'];

        Router::$tree = null;
        Router::connect('/', $wrong);
        Router::connect('/math', $expected);

        self::compareCombos(Router::pathToCombo('http://example.de/math/mathengine/calculate_square_root/'), $expected);
        self::assertFalse(Router::pathToCombo('http://example.de/math/mathengine/calculatesquareroot/'));
    }

    /**
     * Test for {@link Router::pathToCombo()}.
     * In this test, the last slash is missing.
     *
     * @test
     */
    public function urlToComboMissingSlashTest1(): void
    {
        $expected1 = ['controller' => 'Main', 'action' => 'view'];
        $expected2 = ['controller' => 'Hidden', 'action' => 'gone'];

        Router::$tree = null;
        Router::connect('/', $expected1);
        Router::connect('/overpage123/footer/lower', $expected2);

        self::compareCombos($expected1, Router::pathToCombo('http://example.de'));
        self::compareCombos($expected2, Router::pathToCombo('http://example.de/overpage123/footer/lower'));
    }

    public function urlToComboMissingSlashTest2(): void
    {
        Router::$tree = null;
        assertFalse(Router::pathToCombo('http://example.de/f7fiyfifuiy'));
    }

    /**
     * Test for {@link Router::pathToCombo()}.
     * This paths contain different mutations.
     *
     * @test
     */
    public function urlToComboDifferentMutationsTest(): void
    {
        // TODO make this fixPath tests
        $expected1 = ['controller' => 'Main', 'action' => 'view'];
        $expected2 = ['controller' => 'Deep', 'action' => 'in'];

        Router::$tree = null;
        Router::connect('/', $expected1);
        Router::connect('/overpage123/footer/lower', $expected2);

        // used two slashes
        self::compareCombos($expected1, Router::pathToCombo(('http://example.de//')));
        self::compareCombos($expected2, Router::pathToCombo(('http://example.de//overpage123/footer/lower/')));
        self::compareCombos($expected2, Router::pathToCombo(('http://example.de/overpage123//footer/lower/')));
        self::compareCombos($expected2, Router::pathToCombo(('http://example.de/overpage123/footer//lower/')));
        self::compareCombos($expected2, Router::pathToCombo(('http://example.de/overpage123/footer/lower//')));
        self::compareCombos($expected2, Router::pathToCombo(('http://example.de/overpage123\\footer/lower/')));
        self::compareCombos($expected2, Router::pathToCombo(('http://example.de/overpage123///////footer/lower/')));
        self::compareCombos($expected2, Router::pathToCombo(('http://example.de/overpage123//\\\\/footer/lower/')));
    }

    /**
     * Tests for {@link Router::pathToCombo()}.
     * Backslashes followed directly after the domain is interpreted as part of the url instead of the beginning of the path.
     *
     * @test
     */
    public function urlToComboSpecialCaseTest1(): void
    {
        $expected = ['controller' => 'Localhost', 'action' => 'localhost'];

        Router::$tree = null;
        Router::connect('/overpage123/footer/lower', $expected);

        self::compareCombos($expected, Router::pathToCombo(('http://example.de\\/overpage123//\\\\/footer/lower/')));
        self::compareCombos($expected, Router::pathToCombo(('http://example.de\\overpage123//\\overpage123\\/footer/lower/')));
    }

    /**
     * Tests for {@link Router::pathToCombo()}.
     * Without http or https, the host is interpreted in parse_url as part of a path.
     *
     * @test
     */
    public function urlToComboSpecialTest2(): void
    {
        $expected = ['controller' => 'Localhost', 'action' => 'localhost'];

        Router::$tree = null;
        Router::connect('/', $expected);

        self::compareCombos($expected, Router::pathToCombo(('example.de')));
        self::compareCombos($expected, Router::pathToCombo(('localhost')));
        self::compareCombos($expected, Router::pathToCombo(('127.0.0.1')));
    }

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

    /**
     * Tests for {@link Router::comboToPath()}.
     *
     * @test
     */
    public function comboToURLTest1(): void
    {
        Router::$tree = null;
        Router::connect('/', ['controller' => 'Main', 'action' => 'home']);
        Router::connect('/gallery', ['controller' => 'Gallery', 'action' => 'view']);
        Router::connect('/img', ['controller' => 'File', 'action' => 'img']);

        $this->assertEquals(
            '/',
            Router::comboToPath('Main', 'home')
        );
        $this->assertEquals(
            '/gallery',
            Router::comboToPath('Gallery', 'view')
        );
        $this->assertEquals(
            '/img',
            Router::comboToPath('File', 'img')
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