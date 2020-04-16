<?php declare(strict_types=1);

use Core\Configure;
use PHPUnit\Framework\TestCase;

final class ConfigureTest extends TestCase
{
    /**
     * Basic test for {@link Configure::read()} and {@link Configure::set()}.
     *
     * @test
     */
    public function setTest1()
    {
        Configure::set('debug', true);
        self::assertTrue(Configure::read('debug'));
        Configure::set('debug', false);
        self::assertFalse(Configure::read('debug'));
    }

}