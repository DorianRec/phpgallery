<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class UrlHelperTest extends TestCase
{
    static public $json = "{
  \"controller\": \"Main\",
  \"action\": \"view\",
  \"subtree\": {
    \"gallery\": {
      \"controller\": \"Gallery\",
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
    \"txt\": {
      \"controller\": \"File\",
      \"action\": \"txt\",
      \"subtree\": {}
    }
  }
}
";

    /** @test */
    public function buildTest1()
    {
        self::assertEquals(
            '/foo/bar',
            UrlHelper::build([
                'controller' => 'Main',
                'action' => 'view',
                'args' => 'foo/bar'
            ],
                false,
                json_decode(self::$json))
        );

        self::assertEquals(
            '/gallery/foo/bar',
            UrlHelper::build([
                'controller' => 'Gallery',
                'action' => 'view',
                'args' => 'foo/bar'
            ],
                false,
                json_decode(self::$json))
        );

        self::assertEquals(
            '/txt/',
            UrlHelper::build([
                'controller' => 'File',
                'action' => 'txt',
                'args' => ''
            ],
                false,
                json_decode(self::$json))
        );
    }

    /**
     * Tests for {@link UrlHelper::build()}.
     * Here, the Controller and action should not be found and
     * get amend the strings.
     *
     * @test
     */
    public function buildTest2(): void
    {
        self::assertEquals(
            '/not/existing/bla',
            UrlHelper::build([
                'controller' => 'Not',
                'action' => 'existing',
                'args' => 'bla'
            ],
                false,
                json_decode(self::$json))
        );
    }
}