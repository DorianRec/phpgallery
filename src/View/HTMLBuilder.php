<?php
/**
 * This file does contain only the class HTMLBuilder.
 */

/**
 * Class HTMLBuilder
 *
 * This class provides methods for creating HTML lists.
 */
class HTMLBuilder
{

    /**
     * Creates a string, containing a HTML link tag.
     *
     * @param string $text txt of the link
     * @param string $href location of the link
     * @return string containing an HTML link tag, having $txt as txt and $href as location.
     */
    static public function to_link(string $text, string $href): string
    {
        return '<a href="' . $href . '">' . $text . '</a>';
    }

    /**
     * Converts a JSON string into a string, containing HTML links.
     *
     * @param string $json tables string, which should be converted to a HTML links
     * @return string an HTML table, containing the data from $tables
     */
    static public function json_to_table(string $json): string
    {
        return HTMLBuilder::array_to_html_links(json_decode($json));
    }

    /**
     * Converts an array into a string, containing HTML links.
     *
     * @param stdClass $array containing titles, mapping on URLs
     * @return string Contain an HTML link for each mapping
     */
    static public function array_to_html_links(stdClass $array): string
    {
        $links = "";
        foreach ($array as $key => $value) {
            $links .= HTMLBuilder::to_link($key, $value->url);
        }
        return $links;
    }

    /* TODO add gallery builder */
}
