<?php
require_once '../controller/core/init.php';
?>
<html lang="de">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/gallery.css">
    <title>PHPGallery</title>
</head>
<body>
<div class="page-container">
    <div class="header">
        <a class="active" href="#">Active</a>
        <?php echo HTMLBuilder::json_to_table(file_get_contents('../model/header.json')); ?>
    </div>
    <div class="content-wrap">
        <?php echo ImageReader::return_image_HTML_string(ImageReader::read_images('')) ?>
    </div>
    <div class="footer"><?php echo HTMLBuilder::json_to_table(file_get_contents('../model/footer.json')); ?></div>
</div>
</body>
</html>