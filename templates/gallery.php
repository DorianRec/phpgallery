<?php declare(strict_types=1);
?>
<html lang="de">
<head><title>PHPGallery</title>
    <? echo HtmlHelper::css(['styles', 'colors', 'gallery', 'modal']) ?>
</head>
<body>
<div class="page-container">
    <div class="header"><?php include 'header.php'; ?></div>
    <div class="content-wrap">
        <?php echo ImageReader::read_from_json_file($CONTROLLER['tags']) ?>
    </div>
    <div class="footer"><?php include 'footer.php'; ?></div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>

    <img class="modal-content" id="img01">

    <a class="prev" onclick="decrementImageIndex()">&#10094;</a>
    <a class="next" onclick="incrementImageIndex()">&#10095;</a>

    <div id="caption"></div>
</div>

<? echo HtmlHelper::js('modal') ?>
</body>
</html>