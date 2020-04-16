<?php declare(strict_types=1);

namespace Routing;

use Error\Debugger;
use InvalidArgumentException;
use stdClass;
use Utility\Json;

class Router
{

    /**
     * @var stdClass $tree
     */
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
     * @return array the last Controller/action combination, found in {@link Router::$tree}
     * false, otherwise.
     */
    static public function urlToCombo(string $url)
    {
        $content = parse_url($url);
        $parts = explode('/', Router::fixPath($content['path']));
        $parts = array_slice($parts, 1, count($parts) - 2);

        if (self::$tree != null) {
            $output = null;
            // In case, no path except '/' is given
            if (self::terminationCondition(self::$tree)) {
                $output = self::$tree;
                $output->args = $parts;
            }

            // we ignore the first and the last string, since they are empty
            for ($i = 0; $i < count($parts); $i++) {
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
                    if ($output != null) {
                        return Json::stdClassToArray($output);
                    } else {
                        // We could not find a mapping
                        break;
                    }
                }
            }
        }

        if ($output != null) { // return the last found mapping
            return Json::stdClassToArray($output);
        } else {
            if (count($parts) == 2) {// try to improvize
                return ['controller' => $parts[0], 'action' => $parts[1]];
            } else {
                Debugger::dump("Error: {$url} could not be mapped to a Controller::action.");
                return false;
            }
        }
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
        Debugger::dump("Warning: {$controller}::{$action} combo not found!");
        return '/' . strtolower($controller) . "/$action/";
    }
}
