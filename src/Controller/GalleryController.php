<?php declare(strict_types=1);

class GalleryController extends Controller
{
    static public function view(array $pathFragments)
    {
        $CONTROLLER['controller'] = 'Gallery';
        $CONTROLLER['action'] = 'view';
        $CONTROLLER['tags'] = [];
        if ($pathFragments == []) {
            // normal
        } else if ($pathFragments[0] == 'tags' && count($pathFragments) == 2) {
            // TODO add all tags
            // TODO let URL look kind with multiple tags
            $CONTROLLER['tags'] = [$pathFragments[1]];
        } else {
            echo 'error';
            return;
        }

        require_once __DIR__ . '/../../templates/gallery.php';
    }
}
