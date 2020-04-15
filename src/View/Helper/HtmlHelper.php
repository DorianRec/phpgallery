<?php declare(strict_types=1);

namespace View\Helper;

/**
 * Class HtmlHelper
 *
 * This class provides methods for creating HTML lists.
 */
class HtmlHelper
{
    /**
     * //TODO accept also URLs as $path
     * Builds an HTML link tag.
     *
     * @param string $title the title, of the link
     * @param array $path the path, the link points to
     * @param array|null $options array containing options like
     * ['alt' => 'Hills image']
     * @return string an HTML link tag.
     */
    static public function link(string $title, array $path, array $options = []): string
    {
        $attributes = "";
        foreach ($options as $key => $value) {
            $attributes .= "$key=\"$value\" ";
        }
        return "<a $attributes href=\"" . UrlHelper::build($path) . "\" >$title</a>";
    }

    static public function css($path)
    {
        if (gettype($path) == 'string') {
            return "<link rel=\"stylesheet\" href=\"/css/" . $path . ".css\" />\n";
        } else if (gettype($path) == 'array') {
            $output = '';
            foreach ($path as $file) {
                $output .= "<link rel=\"stylesheet\" href=\"/css/" . $file . ".css\" />\n";
            }
            return $output;
        } else
            throw new InvalidArgumentException('$path is of invalid type.');
    }

    /** // TODO PHPDocs
     * @param string $path
     * @param array $options has form [
     *  'pathPrefix' => string
     *  'fullBase' => boolean
     * ]
     * @return string
     */
    static public function image(string $path, array $options = []): string
    {
        $opts = '';
        $prefix = '/img/';
        foreach ($options as $key => $value) {
            if ($key == 'pathPrefix')
                $prefix = $options['pathPrefix'];
            else if ($key == 'fullBase')
                $prefix = UrlHelper::get_protocol_and_domain() . '/img/';
            else
                $opts .= "$key=\"$value\" ";
        }
        return "<img src=\"$prefix" . $path . '" ' . $opts . '/>';
    }

    static public function imageBase64Encoded(string $path, array $options = []): string
    {
        return "<img src='data:image/png;base64," . base64_encode(file_get_contents($path)) . "'>";
    }

    static public function js($path)
    {
        if (gettype($path) == 'string') {
            return "<script src=\"/js/" . $path . ".js\" /></script>\n";
        } else if (gettype($path) == 'array') {
            $output = '';
            foreach ($path as $file) {
                $output .= "<script src=\"/js/" . $path . ".js\" /></script>\n";
            }
            return $output;
        } else
            throw new InvalidArgumentException('$path is of invalid type.');
    }
}
