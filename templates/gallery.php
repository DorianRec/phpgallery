<?php
require_once __DIR__ . '/../src/Core/autoload.php';
?>
<html lang="de">
<head>
    <link rel="stylesheet" href="<? echo URLBuilder::get_protocol_and_domain() . '/webroot/css/styles.css' ?>">
    <link rel="stylesheet" href="<? echo URLBuilder::get_protocol_and_domain() . '/webroot/css/colors.css' ?>">
    <link rel="stylesheet" href="<? echo URLBuilder::get_protocol_and_domain() . '/webroot/css/gallery.css' ?>">
    <title>PHPGallery</title>
</head>
<body>
<div class="page-container">
    <div class="header">
        <?php echo HTMLBuilder::header($CONTROLLER['active']); ?>
    </div>
    <div class="content-wrap">
        <?php echo ImageReader::read_from_json_file($CONTROLLER['tags']) ?>
    </div>
    <div class="footer"><?php echo HTMLBuilder::footer($CONTROLLER['active']); ?></div>
</div>
</body>
</html>