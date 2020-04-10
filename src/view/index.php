<?php
require_once '../core/init.php';
?>
<html lang="de">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>PHPGallery</title>
</head>
<body>
<div class="page-container">
    <div class="header">
        <a class="active"
           href="#">PHPGallery</a><?php echo HTMLBuilder::json_to_table(file_get_contents('../model/header.json')); ?>
    </div>
    <div class="content-wrap">
        <div><p><? echo "1th line" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "(n-1)th line" ?></p></div>
        <div><p><? echo "(n)tn line" ?></p></div>
    </div>
    <div class="footer"><?php echo HTMLBuilder::json_to_table(file_get_contents('../model/footer.json')); ?></div>
</div>
</body>
</html>