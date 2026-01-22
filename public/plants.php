<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/HarvestPlantDAO.php";
    
    session_start();

    if (!isset($_COOKIE['stay-connected']) && !isset($_SESSION['origin'])){
        $_SESSION['invalidLogIn'] = true;
        header("Location: logIn.php");
        exit();
    }

    $user = $_SESSION['user'];
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
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/resources/views/layouts/header.php" ?>
    <main class="container py-4">
        <?=printForHtml("Bienvenido a tu jardín, " . $user->getName(), "h1")?>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/resources/views/layouts/footer.php" ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>