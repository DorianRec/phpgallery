<?php declare(strict_types=1);
require_once __DIR__ . '/../src/Core/autoload.php';
?>
<html lang="de">
<head>
    <link rel="stylesheet" href="<? echo UrlHelper::get_protocol_and_domain() . '/css/styles.css' ?>">
    <link rel="stylesheet" href="<? echo UrlHelper::get_protocol_and_domain() . '/css/colors.css' ?>">
    <link rel="stylesheet" href="<? echo UrlHelper::get_protocol_and_domain() . '/css/gallery.css' ?>">
    <title>PHPGallery</title>
</head>
<body>
<div class="page-container">
    <div class="header">
        <?php echo HtmlHelper::header(['controller' => $CONTROLLER['controller'], 'action' => $CONTROLLER['action']]); ?>
    </div>
    <div class="content-wrap">
        <?php echo ImageReader::read_from_json_file($CONTROLLER['tags']) ?>
    </div>
    <div
            class="footer"><?php echo HtmlHelper::footer(['controller' => $CONTROLLER['controller'], 'action' => $CONTROLLER['action']]); ?></div>
</div>
</body>
</html>