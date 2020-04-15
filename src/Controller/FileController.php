<?php declare(strict_types=1);

namespace Controller;

class FileController extends Controller
{

    static public function css(array $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/css/' . implode('/', $pathFragments);
        if (file_exists($source) && is_file($source)) {
            require_once $source;
            return;
        }
        ErrorController::error('CSS file not found!');
        return;
    }

    static public function html(array $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/html/' . implode('/', $pathFragments);
        if (file_exists($source) && is_file($source)) {
            require_once $source;
            return;
        }
        ErrorController::error('HTML file not found!');
        return;
    }

    static public function img(array $pathFragments)
    {
        $source = __DIR__ . '/../../webroot/img/' . implode('/', $pathFragments);
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

    static public function js(array $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/js/' . implode('/', $pathFragments);
        if (file_exists($source) && is_file($source)) {
            require_once $source;
            return;
        }
        ErrorController::error('JavaScript file not found!');
    }

    static public function txt(array $pathFragments): void
    {
        $source = __DIR__ . '/../../webroot/txt/' . implode('/', $pathFragments);
        if (file_exists($source) && is_file($source)) {
            require_once $source;
            return;
        }
        ErrorController::error('Text file not found!');
    }
}
