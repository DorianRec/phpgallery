<?php declare(strict_types=1);

namespace Routing;

use InvalidArgumentException;
use stdClass;
use Utility\Json;

class Router
{

    public static $tree;

    /**
     * TODO write tests
     * Maps the given path to a specific Controller, action combination.
     *
     * @param string $path
     * '/', '/a/b', '/a/b/*', '/a/b/**'
     * @param $combo
     * Form:
     * 'Controller::action'
     * ['controller' => string, 'action' => string]
     */
    static public function connect(string $path, $combo)
    {
        if (!preg_match("/^(\/|(\/[^\/]*)+)$/", $path))
            throw new InvalidArgumentException('$path does not math ');
        if (gettype($combo) == 'string') {
            [$controller, $action] = explode('::', $combo);
        } else if (gettype($combo) == 'array') {
            $controller = $combo['controller'];
            $action = $combo['action'];
        } else
            throw new InvalidArgumentException('type of $combo not supported.');

        $segments = explode('/', $path);
        $extra = '';
        if ($extra = $segments[count($segments) - 1] == '*' || $extra = $segments[count($segments) - 1] == '**') {
            $segments = array_slice($segments, 1, count($segments) - 2);
        } else
            $segments = array_slice($segments, 1, count($segments) - 1);

        if (self::$tree == null)
            self::$tree = new stdClass();
        $subtree = self::$tree;
        foreach ($segments as $seg) {
            if ($seg != '') {
                if (!property_exists($subtree, 'subtree'))
                    $subtree->subtree = new stdClass();
                if (!property_exists($subtree->subtree, $seg))
                    $subtree->subtree->{$seg} = new stdClass();
                $subtree = $subtree->subtree->{$seg};
            }
        }
        if (!property_exists($subtree, 'controller'))
            $subtree->controller = new stdClass();
        $subtree->controller = $controller;
        if (!property_exists($subtree, 'action'))
            $subtree->action = new stdClass();
        if (!property_exists($subtree, 'subtree'))
            $subtree->subtree = new stdClass();
        $subtree->action = $action;
    }

    /**
     * @param string $url The URL we want to parse
     * @param stdClass|null $tree A tree build of stdClasses. May be null.
     * @return stdClass|boolean The path to a node the URL points to, if it exists. false otherwise.
     * The stdClass contain the fields 'controller', 'action', 'template', 'subtree', 'path'.
     * @deprecated
     */
    static public function treeSearch(string $url, stdClass $tree = null)
    {
        if ($tree == null)
            $tree = json_decode(file_get_contents(__DIR__ . '/../Database/tables/locations.json'));
        $content = parse_url($url);
        if ($content['path'] == null)
            $parts = [];
        else
            $parts = explode('/', Router::fixPath($content['path']));

        // we ignore the first and the last string, since they are empty
        for ($i = 1; $i < count($parts) - 1; $i++) {
            $found = false;
            foreach ($tree->subtree as $key => $page) {
                if (strtolower($key) == strtolower($parts[$i])) {
                    $found = true;
                    $tree = $page;
                    break;
                }
            }
            if (!$found) {
                return false;
            }
        }
        return $tree;
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

    /**
     * Returns the last Controller/action combination,
     * found in the self::$tree,
     * as array.
     *
     * @param string $url the given URL
     * @return array the last Controller/action combination, found in $tree (locations.json by default)
     */
    static public function urlToCombo(string $url): array
    {
        $content = parse_url($url);
        $parts = explode('/', Router::fixPath($content['path']));

        $output = null;
        // In case, no path except '/' is given
        if (self::terminationCondition(self::$tree)) {
            $output = self::$tree;
            $output->args = array_slice($parts, 1, count($parts) - 2);
        }

        $error = [
            'controller' => 'Error',
            'action' => 'error',
            'subtree' => []
        ];
        $error['args'] = array_slice($parts, 1, count($parts) - 2);

        // we ignore the first and the last string, since they are empty
        for ($i = 1; $i < count($parts) - 1; $i++) {
            $found = false;
            foreach (self::$tree->subtree as $key => $page) {
                if (strtolower($key) == strtolower($parts[$i])) {
                    $found = true;
                    $tree = $page;
                    if (self::terminationCondition($tree)) {
                        $output = $tree;
                        $output->args = array_slice($parts, $i + 1, count($parts) - 3);
                    }
                    break;
                }
            }
            if (!$found) {
                if ($output != null)
                    return Json::stdClassToArray($output);
                return $error;
            }
        }
        if ($output != null)
            return Json::stdClassToArray($output);
        return $error;
    }

    static public function terminationCondition(stdClass $node): bool
    {
        return $node->controller != '' &&
            $node->action != '';
    }

    /**
     * Given a controller/action combination,
     * this returns a path, calling this combination
     *
     * @param string $controller {@link Controller}
     * @param string $action the action of {@link Controller}
     * @return string The path if a path exists, which leads to the given $controller/$action combination.
     * /$controller/$action/, otherwise.
     */
    static public function comboToURL(string $controller, string $action): string
    {
        // test initial
        if (self::$tree->controller == $controller && self::$tree->action == $action) {
            return '/';
        }

        // we ignore the first and the last string, since they are empty
        foreach (self::$tree->subtree as $key => $value) {
            if ($value->controller == $controller && $value->action == $action) {
                return "/$key/";
            }
            if (count((array)$key->subtree) > 0) {
                $call = self::comboToURL($controller, $action, $value->subtree);
                if ($call) return "/$call/";
            }
        }
        return '/' . strtolower($controller) . "/$action/";
    }
}
