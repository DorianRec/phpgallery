<?php declare(strict_types=1);

class FileController
{

    static public function css(array $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/css/' . implode('/', $pathFragments);
        if (file_exists($source)) {
            require_once $source;
            return;
        }
    }

    static public function html(array $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/html/' . implode('/', $pathFragments);
        if (file_exists($source)) {
            require_once $source;
            return;
        }
    }

    static public function img(array $pathFragments)
    {
        $source = __DIR__ . '/../../webroot/img/' . implode('/', $pathFragments);
        if (file_exists($source)) {
            $info = getimagesize($source);
            header('Content-Type:' . $info['mime']);
            header('Content-Length: ' . filesize($source));

            if ($info['mime'] == 'image/jpeg') {
                readfile($source);
                //$image = imagecreatefromjpeg($source);
                //imagejpeg($image);
            } elseif ($info['mime'] == 'image/gif') {
                readfile($source);
                //$image = imagecreatefromgif($source);
                //imagegif($image);
            } elseif ($info['mime'] == 'image/png') {
                readfile($source);
                //$image = imagecreatefrompng($source);
                //imagepng($image);
            } else {
                echo 'Filetype not supported yet.';
                return;
            }

        } else {
            echo 'error 404. file not found';
        }
    }

    static public function txt(array $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/txt/' . implode('/', $pathFragments);
        if (file_exists($source)) {
            require_once $source;
            return;
        }
    }
}
