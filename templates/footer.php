<?php declare(strict_types=1);

use View\Helper\HtmlHelper;

$links = [
    'Home' => ['controller' => 'Main', 'action' => 'view'],
    'Gallery' => ['controller' => 'Gallery', 'action' => 'view'],
    'page3' => ['controller' => 'File', 'action' => 'txt'],
    'page4' => ['controller' => 'File', 'action' => 'txt']
];
foreach ($links as $title => $combo) {
    if ($combo['controller'] == $CONTROLLER['controller'] && $combo['action'] == $CONTROLLER['action'])
        echo HtmlHelper::link($title, $combo, ['class' => 'active']);
    else
        echo HtmlHelper::link($title, $combo);
}