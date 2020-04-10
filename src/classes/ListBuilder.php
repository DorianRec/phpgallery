<?php
/**
 * This file does contain only the class ListBuilder.
 */
declare(strict_types=1);

/**
 * Class ListBuilder
 *
 * This class provides methods for creating HTML lists.
 */
class ListBuilder
{

    /**
     * Creates a string, containing a HTML link tag.
     *
     * @param string $text text of the link
     * @param string $href location of the link
     * @return string containing an HTML link tag, having $text as text and $href as location.
     */
    static public function to_link($text, $href): string
    {
        return '<a href="' . $href . '">' . $text . '</a>';
    }

    /**
     * Converts a JSON string into a string, containing an HTML list, filled with this data.
     *
     * @param string $json json string, which should be converted to a HTML table string
     * @return string an HTML table, containing the data from $json
     */
    static public function json_to_table($json): string
    {
        return ListBuilder::array_to_table(json_decode($json));
    }

    /**
     * Converts an array into a string, containing a HTML list, filled with the data from the array.
     *
     * @param string $array an array, which will be converted to an HTML table string
     * @return string An HTML table, containing the data from $array
     */
    static public function array_to_table($array): string
    {
        $table = "";
        foreach ($array as $key => $value) {
            $table .= "<li>" . ListBuilder::to_link($key, $value) . "</li>";
        }
        return "<ul>" . $table . "</ul>";
    }
}