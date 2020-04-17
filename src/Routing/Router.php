<?php declare(strict_types=1);

namespace Routing;

use Error\Debugger;

class Router
{
    /**
     * @var array $mapping
     */
    public static $mapping;

    /**
     * @param string $path
     * @param array $opts
     * Example:
     * ['controller' => string, 'action' => string]
     */
    static public function connect(string $path, array $opts)
    {
        self::$mapping[$path] = $opts;
    }


    static public function resolve(string $uri): array
    {
        $segments = parse_url($uri);
        $path = $segments['path'];

        foreach (self::$mapping as $key => $value) {
            if (preg_match("/^(\/|(\/[^\/]+)+)$/", $key)) {
                if ($key == $path) {
                    Debugger::dump($value, __METHOD__, __LINE__);
                    return $value;
                }
            }
            if (preg_match("/^\/([^\/]+\/)*\*$/", $key)) { // greedy star
                if (substr($key, 0, strlen($key) - 1) == substr($path, 0, strlen($key) - 1)) {
                    $value['args'] = explode('/', substr($path, strlen($key) - 1));
                    Debugger::dump($value, __METHOD__, __LINE__);
                    return $value;
                }
            }
            if (preg_match("/^\/([^\/]+\/)*\*\*$/", $key)) { // trailing star
                if (substr($key, 0, strlen($key) - 2) == substr($path, 0, strlen($key) - 2)) {
                    $value['args'] = substr($path, strlen($key) - 2);
                    Debugger::dump($value, __METHOD__, __LINE__);
                    return $value;
                }
            }
        }

        $output = explode('/', $path, 4);
        $default = [
            'controller' => $output[1],
            'action' => $output[2],
            'args' => '/' . $output[3] . $segments['query'] . $segments['fragment']
        ];
        Debugger::dump($default, __METHOD__, __LINE__);
        return $default;
    }

    static public function desolve(array $combo): string
    {
        if (self::$mapping != null) {
            foreach (self::$mapping as $key => $value) {
                if ($combo['controller'] == $value['controller'] &&
                    $combo['action'] == $value['action']) {
                    return str_replace('*', '', $key);
                }
            }
        }
        return "/{$combo['controller']}/{$combo['action']}";
    }

    /**
     * This validates and repairs a given $path.
     *
     * @param string $path The path given by $_SERVER['path']
     * @return string The fixed path.
     */
    static public function fixPath(string $path): string
    {
        // replace all backslashes to a normal one
        $path = str_replace('\\', '/', $path);
        // shrinks multiple consequtive '///' to a single one
        $path = preg_replace('/\/+/', '/', $path);

        // append slash in front and at the end of the $path, if there is none.
        if (substr($path, 0, 1) != '/')
            $path = '/' . $path;
        if (substr($path, -1, 1) != '/')
            $path .= '/';

        $path = str_replace('/./', '/', $path);
        // evaluates '..'
        while (preg_match('/\/[^\/]*\/\.\.\//', $path)) {
            $path = preg_replace('/\/[^\/]*\/\.\.\//', '/', $path);
        }
        $path = str_replace('/../', '/', $path);

        return $path;
    }
}
