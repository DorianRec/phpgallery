<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

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
     * Test for {@link Router::treeSearch()}.
     * Here we test, whether we get the home page.
     *
     * @test
     */
    public function parseHomeTest1(): void
    {
        $this->assertEquals(
            0,
            Router::treeSearch('http://example.de/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link Router::treeSearch()}.
     * Here we test, whether https is accepted.
     *
     * @test
     */
    public function parseHttpsTest1(): void
    {
        $this->assertEquals(
            0,
            Router::treeSearch('https://example.de/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link Router::treeSearch()}.
     * In this test, the function should answer with the error-page.
     *
     * @test
     */
    public function parseErrorTest1(): void
    {
        $this->assertEquals(
            false,
            Router::treeSearch('http://example.de/f7fiyfifuiy/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link Router::treeSearch()}.
     * Here we test the function with simple paths.
     *
     * @test
     */
    public function parseSimpleTest1(): void
    {
        $this->assertEquals(
            1,
            Router::treeSearch('http://example.de/home/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            2,
            Router::treeSearch('http://example.de/page/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            3,
            Router::treeSearch('http://example.de/overpage123/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link Router::treeSearch()}.
     * Here we test whether the function is able to dive into deep path trees.
     *
     * @test
     */
    public function parseComplexTest1(): void
    {
        $this->assertEquals(
            4,
            Router::treeSearch('http://example.de/overpage123/footer/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123/footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            6,
            Router::treeSearch('http://example.de/overpage123/sunderpage/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link Router::treeSearch()}.
     * In this test, we test whether the function differs between upper and lower caps.
     *
     * @test
     */
    public function parseCapsTest1(): void
    {
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123/footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/OVERPAGE123/FOOTER/LOWER/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/OvErPaGe123/FoOtEr/LoWeR/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link Router::treeSearch()}.
     * In this test, the last slash is missing.
     *
     * @test
     */
    public function parseMissingSlashTest1(): void
    {
        $this->assertEquals(
            "0",
            Router::treeSearch('http://example.de', json_decode(self::$json))->content
        );
        $this->assertEquals(
            false,
            Router::treeSearch('http://example.de/f7fiyfifuiy', json_decode(self::$json))
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123/footer/lower', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link Router::treeSearch()}.
     * This paths contain different mutations.
     *
     * @test
     */
    public function parseDifferentMutationsTest(): void
    {
        // used two slashes
        $this->assertEquals(
            0,
            Router::treeSearch('http://example.de//', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de//overpage123/footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123//footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123/footer//lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123/footer/lower//', json_decode(self::$json))->content
        );
        // used backslash instead of normals slashs
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123\\footer/lower/', json_decode(self::$json))->content
        );
        // multiple slashes
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123///////footer/lower/', json_decode(self::$json))->content
        );
        // mixed slashes and backslashes
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de/overpage123//\\\\/footer/lower/', json_decode(self::$json))->content
        );
    }

    /**
     * Tests for {@link Router::treeSearch()}.
     * Backslashes followed directly after the domain is interpreted as part of the url instead of the beginning of the path.
     *
     * @test
     */
    public function parseSpecialCaseTest1(): void
    {
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de\\/overpage123//\\\\/footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            Router::treeSearch('http://example.de\\overpage123//\\overpage123\\/footer/lower/', json_decode(self::$json))->content
        );
    }

    /**
     * Tests for {@link Router::treeSearch()}.
     * Without http or https, the host is interpreted in parse_url as part of a path.
     *
     * @test
     */
    public function parseSpecialTest2(): void
    {
        $this->assertEquals(
            42,
            Router::treeSearch('example.de', Json::array_to_stdclass(self::$special2))->content
        );
        $this->assertEquals(
            666,
            Router::treeSearch('localhost', Json::array_to_stdclass(self::$special2))->content
        );
        $this->assertEquals(
            666,
            Router::treeSearch('127.0.0.1', Json::array_to_stdclass(self::$special2))->content
        );
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
     * Tests for {@link Router::search_url()}.
     *
     * @test
     */
    public function searchUrlTest1(): void
    {
        $this->assertEquals(
            '',
            Router::search_url('Main', 'view')
        );
        $this->assertEquals(
            '/gallery',
            Router::search_url('Gallery', 'view')
        );
        $this->assertEquals(
            '/img',
            Router::search_url('File', 'img')
        );
    }
}