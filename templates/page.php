<?php declare(strict_types=1);
require_once __DIR__ . '/../src/Core/autoload.php';
?>
<html lang="de">
<head>
    <? echo HtmlHelper::css(['styles', 'colors']) ?>
    <title>PHPGallery</title>
</head>
<body>
<div class="page-container">
    <div class="header">
        <?php echo HtmlHelper::header(['controller' => $CONTROLLER['controller'], 'action' => $CONTROLLER['action']]); ?>
    </div>
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
    <div class="footer"><?php echo HtmlHelper::footer(['controller' => $CONTROLLER['controller'], 'action' => $CONTROLLER['action']]); ?></div>
</div>
</body>
</html>