<?php require_once('../classes/ListBuilder.php'); ?>
<html>
<head></head>
<body>
<header><? echo ListBuilder::json_to_table(file_get_contents('../model/header.json')) ?></header>
<footer></footer>
</body>
<?php

echo "hello world!";
?>
</html>