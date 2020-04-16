<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Routing\Router;
use View\Helper\UrlHelper;

final class UrlHelperTest extends TestCase
{
    /** @test */
    static public function URLCakeTest1()
    {
        Router::$mapping = null;

        self::assertEquals('/posts/view/bar',
            UrlHelper::build([
                "controller" => "Posts",
                "action" => "view",
                "bar",
            ]));
        // TODO support this
        //self::assertEquals('/img/icon.png',
        //    UrlHelper::image('icon.png'));
        //self::assertEquals('/js/app.js',
        //    UrlHelper::script('app.js'));
        //self::assertEquals('/css/app.css',
        //    UrlHelper::css('app.css'));
    }

    /**
     * Tests for {@link UrlHelper::build()}
     *
     * @test
     */
    public function buildTest1()
    {
        Router::$mapping = null;

        self::assertEquals(
            '/main/home/foo/bar',
            UrlHelper::build([
                'controller' => 'Main',
                'action' => 'home',
                'foo/bar'
            ], false
            ));
        self::assertEquals(
            '/gallery/view/foo/bar',
            UrlHelper::build([
                'controller' => 'Gallery',
                'action' => 'view',
                'foo/bar'
            ], false
            ));
        self::assertEquals(
            '/file/txt',
            UrlHelper::build([
                'controller' => 'File',
                'action' => 'txt',
                ''
            ], false)
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
                'bla'
            ], false)
        );
    }


}