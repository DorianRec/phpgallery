<?php declare(strict_types=1);

class ImageReader
{
    public const IMAGE_FOLDER = __DIR__ . '/../../webroot/img/';
    public static $i = 0;

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

    static public function read_from_json_file(array $tags_array): string
    {
        return self::read_from_json(
            json_decode(file_get_contents(__DIR__ . '/../Database/tables/images.json')),
            '',
            $tags_array);
    }

    static public function read_from_json(stdClass $json, string $relative_path, array $tags_array = []): string
    {
        $output = "";
        foreach ($json as $key => $src) {
            if ($src->type == 'dir') {
                $output .= self::read_from_json($src->content,
                    $relative_path . $key . '/',
                    $tags_array);
            } else {
                if (count($tags_array) > 0) {
                    foreach ($tags_array as $tag) {
                        if (in_array($tag, $src->tags)) {
                            $output .= "<div class=\"picture-wrap\">" . HtmlHelper::image($relative_path . $key, [
                                    'class' => 'image',
                                    'id' => 'myImg',
                                    'onclick' => 'openModal();setImageIndex(' . self::$i++ . ')'
                                ]) . "</div>\n";

                            // TODO use base64 on other spots.
                            /*" < div class=\"picture\">
<img src='data:image/png;base64,image/png;base64," . base64_encode(file_get_contents(ImageReader::IMAGE_FOLDER . $relative_path . $key)) . "'>
</div>";*/
                            break;
                        }
                    }
                } else {
                    $output .= "<div class=\"picture-wrap\">" . HtmlHelper::image($relative_path . $key, [
                            'class' => 'image',
                            'id' => 'myImg',
                            'onclick' => 'openModal();setImageIndex(' . self::$i++ . ')'
                        ]) . "</div>\n";

                    // TODO use base64 on other spots.
                    /*" < div class=\"picture\">
<img src='data:image/png;base64," . base64_encode(file_get_contents(ImageReader::IMAGE_FOLDER . $relative_path . $key)) . "'>
</div>";*/
                }
            }
        }
        return $output;
    }
}
