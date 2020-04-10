<?php

use PHPUnit\Framework\TestCase;

final class HTMLBuilderTest extends TestCase
{

    public function testCanBeUsedAsString(): void
    {
        $json = "{
  \"website1\": \"URL1\",
  \"website2\": \"URL2\",
  \"website3\": \"URL3\"
}";
        $this->assertEquals(
            '<a href="URL1">website1</a><a href="URL2">website2</a><a href="URL3">website3</a>',
            HTMLBuilder::json_to_table($json)
        );
    }
}