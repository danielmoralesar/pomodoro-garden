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

    if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['delete']) && !isset($_POST['completeOrOpenTask'])){
        $errorTitle = $errorDeadLine = "";

        $title = secure($_POST['title']);
        $description = isset($_POST['description']) ? secure($_POST['description']) : "";
        $date = strtotime(secure($_POST['deadLine']));
        
        $errorTitle = empty($title) ? printForHtml("El título es obligatorio", "div", "class", "invalid-feedback") : "";
        $errorDate = empty($date) ? printForHtml("Debes ingresar la fecha límite de la tarea", "div", "class", "invalid-feedback") : "";
        $errorDate = ($date > time()) ? printForHtml("La fecha límite no puede ser menor a hoy", "div", "class", "invalid-feedback") : "";

        if (empty($errorTitle) && empty($errorDeadLine)){
            $titleExists = HarvestPlantDAO::select($title, "title") ? true : false;
            if (!$titleExists){
                $newPlant = new HarvestPlant($title, $description, $date);
                HarvestPlantDAO::create($newPlant);
            } else {
                $errorTitle = printForHtml("No se pueden repetir los nombres de las plantas", "div", "class", "invalid-feedback");
            }
        }
    } else if (isset($_POST['delete'])) {
        $plantDelete = HarvestPlantDAO::select($_POST['plantIdDelete'], "id");
        $plantDelete = HarvestPlantDAO::delete($plantDelete);
    } else if (isset($_POST['completeOrOpenTask'])){
        $plant = HarvestPlantDAO::select($_POST['plantIdTask'], "id");
        $plant->completeOrReopenTask(!$plant->getTaskCompleted());
        $plant->calculateHealthPoints();
        $plant->checkPlantState();
        HarvestPlantDAO::update($plant);
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
        <div class="row d-flex justify-content-center align-items-center">
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/resources/views/components/createPlantForm.php" ?>
        </div>
        <?php if(isset($plantDelete)) :?>
            <div class="alert alert-success mt-4 alert-dismissible fade show" role="alert">
                <h3>La planta se ha eliminado con éxito</h3>
                <button class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar" type="button"></button>
            </div>
        <?php endif ?>
        <?php if(isset($newPlant)) :?>
            <div class="alert alert-success mt-4 alert-dismissible fade show" role="alert">
                <h3>La planta se ha creado con éxito</h3>
                <button class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar" type="button"></button>
            </div>
        <?php endif ?>
        <div class="row mt-3">
            <h2>Estas son todas las plantas en el jardín:</h2>
        </div>
        <div class="row">
            <?php
                $plants = HarvestPlantDAO::selectAll();
                if (count($plants) > 0){
                    for ($i=0; $i < count($plants); $i++) { 
                        echo $plants[$i];
                    }
                } else {
                    echo "
                    <div class=\"col-12 col-md-6 col-lg-2\">
                        <div class=\"card\">
                            <div class=\"card-body d-flex justify-content-center align-items-center\">
                                <h5 class=\"card-title\">No hay plantas, crea una tarea</h5>
                            </div>
                        </div>
                    </div>
                    ";
                }
            ?>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/resources/views/layouts/footer.php" ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>