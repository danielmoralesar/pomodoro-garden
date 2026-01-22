<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/HarvestPlantDAO.php";
    
    session_start();

    if (!isset($_COOKIE['stay-connected']) && !isset($_SESSION['origin'])){
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
        <div class="row">
            <div class="col-12">
                <?=printForHtml("Bienvenido a tu jardín, " . $user->getName() . "🧑‍🌾", "h1")?>
            </div>
        </div>
        <div class="row py-4">
            <div class="col-12">
                <h2>Estas son tus 5 primeras plantas</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-2 mb-3">
                <div class="card" style="height: 100%">
                    <div class="card-body d-flex justify-content-center align-items-center" >
                        <h5 class="card-title"><a class="btn btn-outline-success" href="plants.php">Crea una tarea</a></h5>
                    </div>
                </div>
            </div>
            <?php
                $plants = HarvestPlantDAO::selectAll();
                if (count($plants) > 0){
                    $length = count($plants) < 5 ? count($plants) : 5;
                    for ($i=0; $i < $length; $i++) { 
                        echo $plants[$i];
                    }
                }
            ?>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/resources/views/layouts/footer.php" ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>