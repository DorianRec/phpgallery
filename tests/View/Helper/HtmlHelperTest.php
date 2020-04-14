<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class HtmlHelperTest extends TestCase
{
    static public $json = "{
  \"website1\": {
    \"title\": \"\",
    \"url\": \"URL1\",
    \"subpages\": {
    }
  },
  \"website2\": {
    \"title\": \"\",
    \"url\": \"URL2\",
    \"subpages\": {
    }
  },
  \"website3\": {
    \"title\": \"\",
    \"url\": \"URL3\",
    \"subpages\": {
    }
  }
}";

    /** @test */
    public function simpleBuildTest(): void
    {
        $this->assertEquals(
            '<a href="URL1">website1</a><a href="URL2">website2</a><a href="URL3">website3</a>',
            HtmlHelper::json_to_html_link_list(self::$json)
        );
    }
}