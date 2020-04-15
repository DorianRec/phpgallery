<?php declare(strict_types=1);
/**
 * This file does contain only the class HtmlHelper.
 */

/**
 * Class HtmlHelper
 *
 * This class provides methods for creating HTML lists.
 */
class HtmlHelper
{
    /**
     * Gives a string containing HTML links for the header, with the active one highlighted optionally.
     *
     * @param array|null $active array of the form [
     * 'controller' => $controller,
     * 'action' => $action] telling the current page. May be null
     * @return string an HTML table, containing the data from $tables
     */
    static public function header(?array $active): string
    {
        return self::json_to_html_link_list(file_get_contents(__DIR__ . '/../../Database/tables/links.json'), $active);
    }

    /**
     * Gives a string containing HTML links for the footer, with the active one highlighted optionally.
     *
     * @param array|null $active array of the form [
     * 'controller' => $controller,
     * 'action' => $action] telling the current page. May be null
     * @return string an HTML table, containing the data from $tables
     */
    static public function footer(?array $active): string
    {
        return self::json_to_html_link_list(file_get_contents(__DIR__ . '/../../Database/tables/footer.json'), $active);
    }

    /**
     * Converts a JSON string into a string containing HTML links, with the active one highlighted optionally.
     *
     * @param string $json tables string, which should be converted to a HTML links
     * @param array|null $active array of the form [
     * 'controller' => $controller,
     * 'action' => $action] telling the current page. May be null
     * @return string an HTML table, containing the data from $tables
     */
    static public function json_to_html_link_list(string $json, array $active = null): string
    {
        $stdClass = json_decode($json);
        $links = "";
        foreach ($stdClass as $key => $value) {
            if ($active != null && $value->controller == $active['controller'] && $value->action == $active['action'])
                $links .= "<a class=\"active\" href=\"" . UrlHelper::build(['controller' => $value->controller, 'action' => $value->action], true) . "\">{$key}</a>";
            else
                $links .= "<a href=\"" . UrlHelper::build(['controller' => $value->controller, 'action' => $value->action], true) . "\">{$key}</a>";
        }
        return $links;
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
