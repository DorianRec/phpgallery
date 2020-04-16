<?php

use Routing\Router;

Router::connect('/', ['controller' => 'Pages', 'action' => 'home']);
Router::connect('/gallery', ['controller' => 'Gallery', 'action' => 'view']);
Router::connect('/page', ['controller' => 'Pages', 'action' => 'view']);
Router::connect('/css', ['controller' => 'File', 'action' => 'css']);
Router::connect('/html', ['controller' => 'File', 'action' => 'html']);
Router::connect('/img', ['controller' => 'File', 'action' => 'img']);
Router::connect('/js', ['controller' => 'File', 'action' => 'js']);
Router::connect('/txt', ['controller' => 'File', 'action' => 'txt']);
