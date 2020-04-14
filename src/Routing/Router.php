<?php declare(strict_types=1);

class Router
{
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

        return $path;
    }

    static public function findLastSetup(string $url, stdClass $tree = null): stdClass
    {
        if ($tree == null)
            $tree = json_decode(file_get_contents(__DIR__ . '/../Database/tables/locations.json'));
        $content = parse_url($url);
        $parts = explode('/', Router::fixPath($content['path']));

        $output = null;
        // In case, no path except '/' is given
        if (self::terminationCondition($tree)) {
            $output = $tree;
            $output->args = array_slice($parts, 1, count($parts) - 2);
        }

        $error = Json::array_to_stdclass(
            [
                'controller' => 'Error',
                'action' => 'error',
                'subtree' => []
            ]
        );
        $error->args = array_slice($parts, 1, count($parts) - 2);

        // we ignore the first and the last string, since they are empty
        for ($i = 1; $i < count($parts) - 1; $i++) {
            $found = false;
            foreach ($tree->subtree as $key => $page) {
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
                    return $output;
                }
                return $error;
            }
        }
        if ($output != null) {
            return $output;
        }
        return $error;
    }

    static public function terminationCondition(stdClass $node): bool
    {
        return $node->controller != '' &&
            $node->action != '';
    }

    /**
     * @param string $controller
     * @param string $action
     * @param stdClass|null $tree
     * @return bool|string
     */
    static public function search_url(string $controller, string $action, stdClass $tree = null)
    {
        if ($tree == null) {
            $tree = json_decode(file_get_contents(__DIR__ . '/../Database/tables/locations.json'));
        }

        // test initial
        if ($tree->controller == $controller && $tree->action == $action) {
            return '';
        }

        // we ignore the first and the last string, since they are empty
        foreach ($tree->subtree as $key => $value) {
            if ($value->controller == $controller && $value->action == $action) {
                return "/$key";
            }
            if (count((array)$key->subtree) > 0) {
                $call = self::search_url($controller, $action, $value->subtree);
                if ($call) return "/$call";
            }
        }
        return '/' . strtolower($controller) . "/$action";
    }
}
