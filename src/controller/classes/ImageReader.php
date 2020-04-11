<?php

class ImageReader
{
    public const IMAGE_FOLDER = '../model/images/';

    /* TODO Forbid path going back */
    static public function read_images($dir): array
    {
        $files = scandir(ImageReader::IMAGE_FOLDER . $dir);
        return array_slice($files, 2);
    }

    static public function return_image_HTML_string($array): string
    {
        $output = "";
        foreach ($array as $key => $src) {
            $output .= "<div class=\"picture\">
<img src='data:image/png;base64," . base64_encode(file_get_contents(ImageReader::IMAGE_FOLDER . $src)) . "'>
</div>";
        }
        return $output;
    }
}