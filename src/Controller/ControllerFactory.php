<?php

namespace Controller;

use InvalidArgumentException;

class ControllerFactory
{
    /**
     * This is a factory method for creating various types of controllers.
     *
     * @param string $controller the type of {@link Controller}, which should be instantiated
     * @return Controller the withed controller
     * @throws InvalidArgumentException if $controller describes no controller
     */
    static public function build(string $controller): Controller
    {
        switch ($controller) {
            case 'File' :
                return new FileController();
            case 'Gallery' :
                return new GalleryController();
            case 'Main' :
                return new MainController();
            case 'Error' :
                return new ErrorController();
        }
        throw new InvalidArgumentException("{$controller}Controller must describe an Controller.");
    }
}