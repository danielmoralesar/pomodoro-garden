<?php
    session_start();
    if (!isset($_COOKIE['stay-connected']) || !isset($_SESSION['origin'])){
        $_SESSION['invalidLogIn'] = true;
        header("Location: logIn.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomodoro Garden</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/HarvestPlantDAO.php";
    ?>
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <?=printForHtml("Bienvenido a tu jardín, " . $_SERVER['user']->getName(), "h1")?>
            </div>
        </div>
    </div>
    <?php
        
    ?>
</body>
</html>