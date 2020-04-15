<?php declare(strict_types=1);
require_once __DIR__ . '/../src/Core/autoload.php';
?>
<html lang="de">
<head><title>PHPGallery</title>

    <link rel="stylesheet" href="<? echo UrlHelper::get_protocol_and_domain() . '/css/styles.css' ?>">
    <link rel="stylesheet" href="<? echo UrlHelper::get_protocol_and_domain() . '/css/colors.css' ?>">
    <link rel="stylesheet" href="<? echo UrlHelper::get_protocol_and_domain() . '/css/gallery.css' ?>">
    <link rel="stylesheet" href="<? echo UrlHelper::get_protocol_and_domain() . '/css/modal.css' ?>">
</head>
<body
">
<div class="page-container">
    <div class="header">
        <?php echo HtmlHelper::header(['controller' => $CONTROLLER['controller'], 'action' => $CONTROLLER['action']]); ?>
    </div>
    <div class="content-wrap">
        <?php echo ImageReader::read_from_json_file($CONTROLLER['tags']) ?>
    </div>
    <div class="footer"><?php echo HtmlHelper::footer(['controller' => $CONTROLLER['controller'], 'action' => $CONTROLLER['action']]); ?></div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- The Close Button -->
    <span class="close">&times;</span>

    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="img01">

    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
</div>

<script>
    <? include __DIR__ . '/../webroot/js/modal.js' ?>
</script>
</body>
</html>