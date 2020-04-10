<?php
spl_autoload_register(function ($class) {
    include __DIR__ . '/../classes/' . $class . '.php';
});
?>
<html lang="de">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>PHPGallery</title>
</head>
<body>
<div class="header">
    <p><?php echo ListBuilder::json_to_table(file_get_contents('../model/header.json')); ?></p>
</div>
<div class="footer">
    <p><?php echo ListBuilder::json_to_table(file_get_contents('../model/footer.json')); ?></p>
</div>
</body>
<?php

echo "hello world!";
?>
</html>