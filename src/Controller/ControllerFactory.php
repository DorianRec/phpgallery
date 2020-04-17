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
        switch (strtolower($controller)) {
            case strtolower('File'):
                return new FileController();
            case strtolower('Gallery'):
                return new GalleryController();
            case strtolower('Pages') :
                return new PagesController();
        }
        Debugger::dump("<b>Error:</b> No Controller {$controller} could be resolved!", __METHOD__, __LINE__);
        return false;
    }
}