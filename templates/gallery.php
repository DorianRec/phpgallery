<?php
require_once __DIR__ . '/../src/Core/autoload.php';
?>
<html lang="de">
<head>
    <link rel="stylesheet" href="<? echo '../webroot/css/styles.css' ?>">
    <link rel="stylesheet" href="<? echo '../webroot/css/colors.css' ?>">
    <link rel="stylesheet" href="<? echo '../webroot/css/gallery.css' ?>">
    <title>PHPGallery</title>
</head>
<body>
<div class="page-container">
    <div class="header">
        <a class="active" href="#">Active</a>
        <?php echo HTMLBuilder::json_to_table(file_get_contents(__DIR__ . '/../src/Database/tables/links.json')); ?>
    </div>
    <div class="content-wrap">
        <?php echo ImageReader::read_from_json_file() ?>
    </div>
    <div class="footer"><?php echo HTMLBuilder::json_to_table(file_get_contents(__DIR__ . '/../src/Database/tables/footer.json')); ?></div>
</div>
</body>
</html>