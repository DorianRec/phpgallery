<?php declare(strict_types=1);

namespace Controller;

class FileController extends Controller
{

    static public function css(string $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/css/' . $pathFragments;
        if (file_exists($source) && is_file($source)) {
            require_once $source;
            return;
        }
        ErrorController::error("CSS file \"$source\" not found!");
        return;
    }

    static public function html(string $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/html/' . $pathFragments;
        if (file_exists($source) && is_file($source)) {
            require_once $source;
            return;
        }
        ErrorController::error('HTML file not found!');
        return;
    }

    static public function img(string $pathFragments)
    {
        $source = __DIR__ . '/../../webroot/img/' . $pathFragments;
        if (file_exists($source) && is_file($source)) {
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
                ErrorController::error('Filetype not supported yet.');
                return;
            }

        }
        ErrorController::error('Image file not found!');
    }

    static public function js(string $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/js/' . $pathFragments;
        if (file_exists($source) && is_file($source)) {
            require_once $source;
            return;
        }
        ErrorController::error('JavaScript file not found!');
    }

    static public function txt(string $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/txt/' . $pathFragments;
        if (file_exists($source) && is_file($source)) {
            require_once $source;
            return;
        }
        ErrorController::error('Text file not found!');
    }
}
