<?php

class FileController
{
    // TODO rule . and ..
    static public function view(array $pathFragments): void
    {
        require_once __DIR__ . '/../../webroot/' . implode('/', $pathFragments);
    }
}
