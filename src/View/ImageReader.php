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
     * @deprecated
     */
    static public function return_image_html_string(array $array): string
    {
        $output = "";
        foreach ($array as $key => $src) {
            $output .= "<div class=\"picture\">
<img src='data:image/png;base64," . base64_encode(file_get_contents(ImageReader::IMAGE_FOLDER . $src)) . "'>
</div>";
        }
        return $output;
    }

    static public function read_from_json_file(): string
    {
        return self::read_from_json(json_decode(file_get_contents(__DIR__ . '/../Database/tables/images.json')), '');
    }

    static public function read_from_json(stdClass $json, string $relative_path): string
    {
        $output = "";
        foreach ($json as $key => $src) {
            if ($src->type == 'dir') {
                $output .= self::read_from_json($src->content, $relative_path . $key . '/');
            } else {
                $output .= "<div class=\"picture\">
<img src='data:image/png;base64," . base64_encode(file_get_contents(ImageReader::IMAGE_FOLDER . $relative_path . $key)) . "'>
</div>";
            }
        }
        return $output;
    }
}
