<?php

require_once "autoload.php";

use euroControllers\Router;


$router = new Router();
$page = $router->get($_GET);

?>

<!doctype html>
<html lang="fr_FR">
<head>
    <meta charset="UTF-8">
    <title>UEFA</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php echo $page ?>
</body>
</html>
