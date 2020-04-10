<?php

use PHPUnit\Framework\TestCase;

final class FooterTest extends TestCase
{

    public function testCanBeUsedAsString(): void
    {
        $json = "{
  \"website1\": \"URL1\",
  \"website2\": \"URL2\",
  \"website3\": \"URL3\"
}";
        $this->assertEquals(
            '<ul><li><a href="URL1">website1</a></li><li><a href="URL2">website2</a></li><li><a href="URL3">website3</a></li></ul>',
            ListBuilder::json_to_table($json)
        );
    }
}