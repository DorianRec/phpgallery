<?php declare(strict_types=1);

class FileController
{
    // TODO rule . and ..
    static public function css(array $pathFragments): void
    {
        require_once __DIR__ . '/../../webroot/css/' . implode('/', $pathFragments);
    }

    static public function html(array $pathFragments): void
    {
        require_once __DIR__ . '/../../webroot/html/' . implode('/', $pathFragments);
    }

    static public function img(array $pathFragments): void
    {
        require_once __DIR__ . '/../../webroot/img/' . implode('/', $pathFragments);
    }

    static public function txt(array $pathFragments): void
    {
        require_once __DIR__ . '/../../webroot/txt/' . implode('/', $pathFragments);
    }
}
