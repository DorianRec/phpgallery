<?php declare(strict_types=1); ?>
<html lang="de">
<head>
    <? use View\Helper\HtmlHelper;

    echo HtmlHelper::css(['styles', 'colors_custom']) ?>
    <title>PHPGallery</title>
</head>
<body>
<div class="page-container">
    <div class="header"><h1>PHPGallery</h1>
        <?php include 'header.php'; ?></div>
    <div class="content-wrap">
        <div><p><? echo file_get_contents(__DIR__ . '/../webroot/txt/text.txt') ?></p></div>
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
        <div><p><? echo "hello world!" ?></p></div>
        <div><p><? echo "(n-1)th line" ?></p></div>
        <div><p><? echo "(n)tn line" ?></p></div>
    </div>
    <div class="footer"><?php include 'footer.php'; ?></div>
</div>
</body>
</html>