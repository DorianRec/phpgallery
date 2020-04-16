<?php declare(strict_types=1);

namespace View\Helper;

use InvalidArgumentException;
use Routing\Router;

/**
 * Class UrlHelper
 * This class contain helper methods for handling URLs.
 *
 * @package View\Helper
 */
class UrlHelper
{
    /**
     * Returns the current URL.
     * Example:
     * http://example.de/path/to/location
     *
     * @return string the current URL
     */
    static public function get_url(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    /**
     * Returns the current protocol and domain.
     * Example: http://example.de
     *
     * @return string the current protocol and domain.
     */
    static public function get_protocol_and_domain(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    }

    /**
     * Converts a controller/action combination into a path.
     * // TODO accept ULRs as $struct
     * @param array $struct containing the controller/action combination
     * Example: [
     *  'controller' => 'Gallery'
     *  'action' => 'view'
     *  'foo/bar' // optional
     * ]
     * @param bool $full tells, whether protocol and domain should be appended to url. (false by default)
     * @return string the path pointing to the given controller/action combination in $struct.
     * Example:
     * '/gallery/view/foo/bar'
     */
    static public function build(array $struct, bool $full = false): string
    {
        if (!isset($struct['controller']) || !isset($struct['action']))
            throw new InvalidArgumentException('$struct[\'controller\'] and $struct[\'action\'] must be set!');

        $protocol_and_domain = '';
        if ($full) $protocol_and_domain .= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        $args = '';
        for ($i = 0; $i < count($struct) - 2; $i++) {
            if ($struct[$i] != '') $args .= "/{$struct[$i]}";
        }

        if (!$path = Router::comboToPath($struct['controller'], $struct['action']))
            $path = "/{$struct['controller']}/{$struct['action']}";

        return strtolower($protocol_and_domain . $path . $args);
    }
}
