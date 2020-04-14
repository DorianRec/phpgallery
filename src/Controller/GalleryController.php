<?php

class GalleryController extends Controller
{
    static public function view(array $pathFragments)
    {
        $CONTROLLER['active'] = 'gallery';
        $CONTROLLER['tags'] = [];
        if ($pathFragments[0] == 'tags') {
            // TODO add all tags
            // TODO let URL look kind with multiple tags
            $CONTROLLER['tags'] = [$pathFragments[1]];
        }
        require_once __DIR__ . '/../../templates/gallery.php';
    }
}
