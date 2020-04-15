<?php declare(strict_types=1);

$links = [
    'Home' => ['controller' => 'Main', 'action' => 'view'],
    'Gallery' => ['controller' => 'Gallery', 'action' => 'view']
];
foreach ($links as $title => $combo) {
    if ($combo['controller'] == $CONTROLLER['controller'] && $combo['action'] == $CONTROLLER['action'])
        echo HtmlHelper::link($title, $combo, ['class' => 'active']);
    else
        echo HtmlHelper::link($title, $combo);
}