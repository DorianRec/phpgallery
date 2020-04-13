<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class URLParserTest extends TestCase
{

    static public $json = "{
  \"title\": \"root\",
  \"content\": 0,
  \"subtree\": {
    \"home\": {
      \"title\": \"home123\",
      \"content\": 1,
      \"subtree\": {}
    },
    \"page\": {
      \"title\": \"homes123\",
      \"content\": 2,
      \"subtree\": {}
    },
    \"overpage123\": {
      \"title\": \"overpage123\",
      \"content\": 3,
      \"subtree\": {
        \"footer\": {
          \"title\": \"FOOTER\",
          \"content\": 4,
          \"subtree\": {
            \"lower\": {
              \"title\": \"looooower\",
              \"content\": 5,
              \"subtree\": {}
            }
          }
        },
        \"sunderpage\": {
          \"title\": \"sunderpage\",
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
    static public $special3 = "{
  \"title\": \"root\",
  \"content\": 0,
  \"subtree\": {
    \"example.de\": {
        \"title\": \"example-page\",
        \"content\": 42,
        \"subtree\": {}
    },
    \"localhost\": {
        \"title\": \"Home is where the heart is.\",
        \"content\": 666,
        \"subtree\": {}
    },
    \"127.0.0.1\": {
        \"title\": \"Home is where the heart is.\",
        \"content\": 666,
        \"subtree\": {}
    }
  }
}";

    /**
     * Test for {@link URLParser::treeSearch()}.
     * Here we test, whether we get the home page.
     *
     * @test
     */
    public function parseHomeTest1(): void
    {
        $this->assertEquals(
            0,
            URLParser::treeSearch('http://example.de/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link URLParser::treeSearch()}.
     * Here we test, whether https is accepted.
     *
     * @test
     */
    public function parseHTTPSTest1(): void
    {
        $this->assertEquals(
            0,
            URLParser::treeSearch('https://example.de/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link URLParser::treeSearch()}.
     * In this test, the function should answer with the error-page.
     *
     * @test
     */
    public function parseErrorTest1(): void
    {
        $this->assertEquals(
            false,
            URLParser::treeSearch('http://example.de/f7fiyfifuiy/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link URLParser::treeSearch()}.
     * Here we test the function with simple paths.
     *
     * @test
     */
    public function parseSimpleTest1(): void
    {
        $this->assertEquals(
            1,
            URLParser::treeSearch('http://example.de/home/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            2,
            URLParser::treeSearch('http://example.de/page/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            3,
            URLParser::treeSearch('http://example.de/overpage123/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link URLParser::treeSearch()}.
     * Here we test whether the function is able to dive into deep path trees.
     *
     * @test
     */
    public function parseComplexTest1(): void
    {
        $this->assertEquals(
            4,
            URLParser::treeSearch('http://example.de/overpage123/footer/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123/footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            6,
            URLParser::treeSearch('http://example.de/overpage123/sunderpage/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link URLParser::treeSearch()}.
     * In this test, we test whether the function differs between upper and lower caps.
     *
     * @test
     */
    public function parseCapsTest1(): void
    {
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123/footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/OVERPAGE123/FOOTER/LOWER/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/OvErPaGe123/FoOtEr/LoWeR/', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link URLParser::treeSearch()}.
     * In this test, the last slash is missing.
     *
     * @test
     */
    public function parseMissingSlashTest1(): void
    {
        $this->assertEquals(
            0,
            URLParser::treeSearch('http://example.de', json_decode(self::$json))->content
        );
        $this->assertEquals(
            false,
            URLParser::treeSearch('http://example.de/f7fiyfifuiy', json_decode(self::$json))
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123/footer/lower', json_decode(self::$json))->content
        );
    }

    /**
     * Test for {@link URLParser::treeSearch()}.
     * This paths contain different mutations.
     *
     * @test
     */
    public function parseDifferentMutationsTest(): void
    {
        // used two slashes
        $this->assertEquals(
            0,
            URLParser::treeSearch('http://example.de//', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de//overpage123/footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123//footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123/footer//lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123/footer/lower//', json_decode(self::$json))->content
        );
        // used backslash instead of normals slashs
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123\\footer/lower/', json_decode(self::$json))->content
        );
        // multiple slashes
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123///////footer/lower/', json_decode(self::$json))->content
        );
        // mixed slashes and backslashes
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de/overpage123//\\\\/footer/lower/', json_decode(self::$json))->content
        );
    }

    /**
     * Tests for {@link URLParser::treeSearch()}.
     * Backslashes followed directly after the domain is interpreted as part of the url instead of the beginning of the path.
     *
     * @test
     */
    public function parseSpecialCaseTest1(): void
    {
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de\\/overpage123//\\\\/footer/lower/', json_decode(self::$json))->content
        );
        $this->assertEquals(
            5,
            URLParser::treeSearch('http://example.de\\overpage123//\\overpage123\\/footer/lower/', json_decode(self::$json))->content
        );
    }

    /**
     * Tests for {@link URLParser::treeSearch()}.
     * Without http or https, the host is interpreted in parse_url as part of a path.
     *
     * @test
     */
    public function parseSpecialTest2(): void
    {
        $this->assertEquals(
            42,
            URLParser::treeSearch('example.de', json_decode(json_encode(self::$special2)))->content
        );
        $this->assertEquals(
            666,
            URLParser::treeSearch('localhost', json_decode(json_encode(self::$special2)))->content
        );
        $this->assertEquals(
            666,
            URLParser::treeSearch('127.0.0.1', json_decode(json_encode(self::$special2)))->content
        );
    }

    /**
     * Tests for {@link URLParser::fixPath()}.
     * Tests, whether the backslashes are replaced by slashes.
     *
     * @test
     */
    public function fixPathTest1(): void
    {
        $this->assertEquals(
            '/a/b/c/',
            URLParser::fixPath('\\a\\b\\c\\')
        );
    }

    /**
     * Tests for {@link URLParser::fixPath()}.
     * Tests whether multiple consequtive '///' are shrinked to a single one.
     *
     * @test
     */
    public function fixPathTest2(): void
    {
        $this->assertEquals(
            '/a/b/',
            URLParser::fixPath('/a/////b/')
        );
    }

    /**
     * Tests for {@link URLParser::fixPath()}.
     * Tests, whether slashes are appended at the start and the end of the string, if there are none.
     *
     * @test
     */
    public function fitPathMissingTest1(): void
    {
        $this->assertEquals(
            '/a/b/',
            URLParser::fixPath('a/b')
        );
        $this->assertEquals(
            '/a/b/',
            URLParser::fixPath('/a/b')
        );
        $this->assertEquals(
            '/a/b/',
            URLParser::fixPath('a/b/')
        );
    }

    /**
     * Tests for {@link URLParser::fixPath()}.
     * Tests, whether something weird happens on a base path.
     *
     * @test
     */
    public function fixPathSlashTest1(): void
    {
        $this->assertEquals(
            '/',
            URLParser::fixPath('/')
        );
    }

    /**
     * Tests for {@link URLParser::fixPath()}.
     * Tests, whether multiple backslashes and slashes are shrinked to a single slash.
     *
     * @test
     */
    public function fixPathCombinationTest1(): void
    {
        $this->assertEquals(
            '/a/b/',
            URLParser::fixPath('/a///\\\\\\b/')
        );
    }
}