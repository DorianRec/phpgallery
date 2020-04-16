<?php declare(strict_types=1);

namespace Routing;

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
        if (!preg_match("/^(\/|(\/[^\/]+)+)$/", $path))
            throw new InvalidArgumentException('$path does not math ');
        if (gettype($combo) == 'string') {
            [$controller, $action] = explode('::', $combo);
        } else if (gettype($combo) == 'array') {
            [$controller, $action] = [$combo['controller'], $combo['action']];
        } else
            throw new InvalidArgumentException('type of $combo not supported.');

        $segments = explode('/', $path);
        $extra = ''; // TODO handle this
        if ($extra = $segments[count($segments) - 1] == '*' || $extra = $segments[count($segments) - 1] == '**') {
            $segments = array_slice($segments, 1, count($segments) - 2);
        } else
            $segments = array_slice($segments, 1, count($segments) - 1);

        if (self::$tree == null)
            self::$tree = new stdClass();
        $subtree = self::$tree;

        // dive
        foreach ($segments as $seg) {
            if ($seg != '') { // TODO why is this here ?
                if (!property_exists($subtree, 'subtree'))
                    $subtree->subtree = new stdClass();
                if (!property_exists($subtree->subtree, $seg))
                    $subtree->subtree->{$seg} = new stdClass();
                $subtree = $subtree->subtree->{$seg};
            } else {
                echo '#################SEGMENTS#################';
                print_r($segments);
                echo 'ENDE';
            }
        }

        // write data into tree
        if (!property_exists($subtree, 'controller'))
            $subtree->controller = new stdClass();
        $subtree->controller = $controller;
        if (!property_exists($subtree, 'action'))
            $subtree->action = new stdClass();
        $subtree->action = $action;
        if (!property_exists($subtree, 'subtree'))
            $subtree->subtree = new stdClass();
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
     * Returns the <b>last</b> Controller/action combination as array, if it exists in {@link Router::$tree}.
     * false otherwise.
     *
     * @param string $path the given path
     * Examples:
     * '/', '/a', '/a/b'
     * NOT:
     * No ending slash: '/a/', '/a/b/' (except trivial path '/').
     * @return array|bool the <b>last</b> Controller/action combination, found in {@link Router::$tree}
     * false, otherwise.
     */
    static public function pathToCombo(string $path)
    {
        if (!preg_match("/^(\/|(\/[^\/]+)+)$/", $path))
            throw new InvalidArgumentException('$path is invalid!');

        $parts = explode('/', Router::fixPath($path));
        $parts = array_slice($parts, 1, count($parts) - 1);
        if (self::$tree == null) return false;
        $output = null;
        // In case, no path except '/' is given
        if (self::terminationCondition(self::$tree)) {
            $output = self::$tree;
            $output->args = $parts;
        }
        if ($parts[0] == '') {
            if ($output != null) return Json::stdClassToArray($output);
            else return false;
        }

        // we ignore the first and the last string, since they are empty
        for ($i = 0; $i < count($parts); $i++) {
            $found = false;
            foreach (self::$tree->subtree as $key => $page) {
                if (strtolower($key) == strtolower($parts[$i])) {
                    $found = true;
                    $tree = $page;
                    if ($tree == null) {
                        echo "sfjosigoghoig";
                        print_r($tree);
                        echo 'asdkjaskd';
                    }
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
                    return false;
                }
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
     * this returns a path from the {@link Router::$tree} if one exists. (May be '/')
     * Otherwise it returns false.
     *
     * @param string $controller {@link Controller}
     * @param string $action the action of {@link Controller}
     * @param stdClass|null $tree the (sub-)tree, we search the controller/action combination.
     * @return string|bool The path which leads to the given $controller/$action combination if it exists.
     * false, otherwise.
     */
    static public function comboToPath(string $controller, string $action, stdClass $tree = null)
    {
        if ($tree == null) $tree = self::$tree;
        if ($tree == null) return false;

        // test initial
        if ($tree->controller == $controller && $tree->action == $action) return '/';


        // we ignore the first and the last string, since they are empty
        foreach ($tree->subtree as $key => $value) {
            if ($value->controller == $controller && $value->action == $action) {
                return "/$key";
            }
            if (count((array)$key->subtree) > 0) {
                $call = self::comboToPath($controller, $action, $value->subtree);
                if ($call) return "/$call";
            }
        }
        return false;
    }
}
