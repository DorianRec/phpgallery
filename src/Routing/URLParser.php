<?php

class URLParser
{
    /**
     * @param string $url The URL we want to parse
     * @param stdClass|null $tree A tree build of stdClasses. May be null.
     * @return stdClass|boolean The path to a node the URL points to, if it exists. false otherwise.
     * The stdClass contain the fields 'controller', 'action', 'template', 'subtree', 'path'.
     * @deprecated
     */
    static public function treeSearch(string $url, ?stdClass $tree = null)
    {
        if ($tree == null)
            $tree = json_decode(file_get_contents(__DIR__ . '/../Database/tables/locations.json'));
        $content = parse_url($url);
        $parts = explode('/', URLParser::fixPath($content['path']));

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
    static public function fixPath($path): string
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

    static public function findLastSetup(string $url, ?stdClass $tree = null): stdClass
    {
        $output = null;
        $error = Json::array_to_stdclass(
            [
                'controller' => 'Controller',
                'action' => 'error',
                'template' => 'error',
                'subtree' => [],
                'path' => [$url]
            ]
        );

        if ($tree == null)
            $tree = json_decode(file_get_contents(__DIR__ . '/../Database/tables/locations.json'));
        $content = parse_url($url);
        $parts = explode('/', URLParser::fixPath($content['path']));

        // we ignore the first and the last string, since they are empty
        for ($i = 1; $i < count($parts) - 1; $i++) {
            $found = false;
            foreach ($tree->subtree as $key => $page) {
                if (strtolower($key) == strtolower($parts[$i])) {
                    $found = true;
                    $tree = $page;
                    if (self::terminationCondition($tree)) {
                        $output = $tree;
                        $output->path = (object)array_slice($parts, $i + 1, count($parts) - 3);
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

    // TODO allow '.' and '..'

    static public function terminationCondition(stdClass $node): bool
    {
        return $node->controller != '' &&
            $node->action != '' &&
            $node->template != '';
    }
}
