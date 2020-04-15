<?php declare(strict_types=1);

class UrlHelper
{
    static public function get_url(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    static public function get_protocol_and_domain(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    }

    /**
     * // TODO kick $json
     * // TODO acceppt ULRs as $struct
     * @param array $struct of the form
     * [
     *  'controller' => 'Gallery'
     *  'action' => 'view'
     *  'args' => 'foo/bar'
     * ]
     * @param bool $full tells, whether protocol and domain should be appended to url.
     * @param stdClass|null $json the database containing the controller, action/url mapping
     * @return string the URL, like
     * '/gallery/view/foo/bar/'
     */
    static public function build(array $struct, bool $full = false, stdClass $json = null): string
    {
        $protocol_and_domain = '';
        if ($full)
            $protocol_and_domain .= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        $args = ($struct['args'] != "") ? $args = "{$struct['args']}" : $args = "";
        return $protocol_and_domain . Router::searchPath($struct['controller'], $struct['action'], $json) . $args;
    }
}
