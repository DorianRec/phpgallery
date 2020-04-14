<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class HTMLBuilderTest extends TestCase
{
    /** @test */
    public function simpleBuildTest(): void
    {
        $json = "{
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
        $this->assertEquals(
            '<a href="URL1">website1</a><a href="URL2">website2</a><a href="URL3">website3</a>',
            HTMLBuilder::json_to_html_link_list($json)
        );
    }
}