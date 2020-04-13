<?php

class ImageReader
{
    public const IMAGE_FOLDER = __DIR__ . '/../../webroot/img/';

    /* TODO Forbid path going back */
    static public function read_images($dir): array
    {
        $files = scandir(ImageReader::IMAGE_FOLDER . $dir);
        return array_slice($files, 2);
    }

    /**
     * The reads all images from {@link ImageReader::IMAGE_FOLDER} and
     * returns out an HTML string, containing them.
     *
     * @param array $array containing the sources of each image in {@link ImageReader::IMAGE_FOLDER}
     * @return string HTML-string, containing each image.
     */
    static public function return_image_HTML_string(array $array): string
    {
        $output = "";
        foreach ($array as $key => $src) {
            $output .= "<div class=\"picture\">
<img src='data:image/png;base64," . base64_encode(file_get_contents(ImageReader::IMAGE_FOLDER . $src)) . "'>
</div>";
        }
        return $output;
    }

    /* TODO add gallery builder, reading from json */
}
