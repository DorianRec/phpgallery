<?php declare(strict_types=1);

namespace Controller;

use Error\Debugger;

class GalleryController extends Controller
{
    static public function view(array $pathFragments)
    {
        $CONTROLLER['controller'] = 'Gallery';
        $CONTROLLER['action'] = 'view';
        $CONTROLLER['tags'] = [];
        if ($pathFragments == []) {
            // TODO add images here.
        } else if ($pathFragments[0] == 'tags' && count($pathFragments) <= 2) {
            $CONTROLLER['tags'] = [$pathFragments[1]];
        } else {
            Debugger::dump("Wrong number of arguments!", __METHOD__, __LINE__);
            ErrorController::error('404 Page not found!');
        }

        require_once __DIR__ . '/../../templates/gallery.php';
    }
}
