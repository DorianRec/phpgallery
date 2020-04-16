<?php

namespace Controller;

use Error\Debugger;
use InvalidArgumentException;

class ControllerFactory
{
    /**
     * This is a factory method for creating various types of controllers.
     *
     * @param string $controller the type of {@link Controller}, which should be instantiated
     * @return bool|Controller A new controller instance if $controller specifies one. false otherwise.
     * @throws InvalidArgumentException if $controller describes no controller
     */
    static public function build(string $controller)
    {
        switch ($controller) {
            case 'File' :
                return new FileController();
            case 'Gallery' :
                return new GalleryController();
            case 'Pages' :
                return new PagesController();
        }
        Debugger::dump("Error: In Controller\ControllerFactory::build<br>
No Controller {$controller} could be resolved!");
        return false;
    }
}