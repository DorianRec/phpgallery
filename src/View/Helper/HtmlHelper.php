<?php
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
     * @param string $active tells, which link is currently active. '' on default.
     * @return string an HTML table, containing the data from $tables
     */
    static public function header(string $active = ''): string
    {
        return self::json_to_html_link_list(file_get_contents(__DIR__ . '/../../Database/tables/links.json'), $active);
    }

    /**
     * Gives a string containing HTML links for the footer, with the active one highlighted optionally.
     *
     * @param string $active tells, which link is currently active. '' on default.
     * @return string an HTML table, containing the data from $tables
     */
    static public function footer(string $active = ''): string
    {
        return self::json_to_html_link_list(file_get_contents(__DIR__ . '/../../Database/tables/footer.json'), $active);
    }

    /**
     * Converts a JSON string into a string containing HTML links, with the active one highlighted optionally.
     *
     * @param string $json tables string, which should be converted to a HTML links
     * @param string $active tells, which link is currently active. '' on default.
     * @return string an HTML table, containing the data from $tables
     */
    static public function json_to_html_link_list(string $json, string $active = ''): string
    {
        $stdClass = json_decode($json);
        $links = "";
        foreach ($stdClass as $key => $value) {
            if ($key == $active)
                $links .= "<a class=\"active\" href=\"{$value->url}\">{$key}</a>";
            else
                $links .= "<a href=\"{$value->url}\">{$key}</a>";
        }
        return $links;
    }
}
