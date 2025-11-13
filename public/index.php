<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/FruitTree.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/DecorativePlant.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomodoro Garden</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <article>
        <h1>Pomodoro Garden</h1>
        <p>Pomodoro Garden será una aplicación web que gamifica la consecusión de tareas pendientes y hábitos del usuario. La idea es simple, veremos las tareas como plantas a las que hay que cuidar, el usuario será responsable de mantenerlas vivas mientras las realice, y podrá coleccionarlas en su gardín personal.</p>
        <p>El gráfico UML de la aplicación es el siguiente:</p>
        <!-- TODO meter el gráfico UML de la app aquí -->
        <p>De momento, por limitaciones de conocimiento, el reloj pomodoro no está disponible, así que experimentaremos con la app con valores hardcodeados aquí mismo</p>
    </article>
    <article>
        <h2>Clase User:</h2>
        <p>Como el nombre lo indica, representa a le usuarie, el cual se compone de los siguentes parámetros:</p>
        <!-- TODO meter aquí el gráfico UML de USER-->
        <p>Vamos a crear un usuario y experimentar con este: </p>
        <?php 
            $user1 = new User("Gato","gato@pomodorogarden.com");

            echo $user1;
        ?>
        <p>Ahora que el usuario se ha creado, vamos a crearle un jardín con el método <code>createGarden()</code> se le pasarán como parámetros, el nombre del jardín, y la Path del ambiente del jardín</p>
        <?php 
            echo printBool($user1->createGarden("TO-DO list", "/resources/assets/waterfall.gif"));
        ?>
        <p>Hemos recibido un true como respuesta, eso significa que el jardín se ha creado con éxito.</p>
        <?php
            echo $user1;
        ?>
        <p>Pero, ¿qué pasaría si creamos de nuevo otro jardín con el mísmo título?</p>
        <?php 
            echo printBool($user1->createGarden("TO-DO list", "/resources/assets/waterfall.gif"));
        ?>
        <p>Recibiremos un false, como se puede ver, no será posible tener jardines con los mísmos títulos, ya que identificaremos los jardines mediante estos, cuando tengamos la base de datos, estos serán la clave primaria. Podemos realizar busquedas para ver si existe el jardín antes de crearlo con el siguiente método, <code>gardenExist()</code></p>
        <?php 
            echo printBool($user1->gardenExist("TO-DO list"));
        ?>
        <p>¿Y si queremos cambiarle el nombre al jardín? Podemos hacerlo con la función <code>changeGardenTitle()</code></p>
        <?php 
            echo printBool($user1->changeGardenTitle("TO-DO list", "Pomodoro Project"));
            echo $user1;
        ?>
        <p>Listo, dejaremos creado los dos jardines para posteriores pruebas</p>
        <p>Otro método que puede ayudar al usuarie, puede ser el método <code>findGarden()</code>, que como su nombre indica, busca y devuelve un objeto Jardín</p>
        <?php 
            $user1->createGarden("TO-DO list", "/resources/assets/waterfall.gif");
            $user1->createGarden("Delete me", "/resources/assets/waterfall.gif");
            echo $user1;
            $exampleGarden = $user1->findGarden("TO-DO list");
            echo $exampleGarden;
        ?>
        <p>Ahora, digamos que un usuarie quiere eliminar un jardin, para eso tenemos el método <code>deleteGarden()</code>, al igual que los métodos anteriores devuelve true o false dependiendo si se logró eliminar el jardín</p>
        <?php 
            echo printBool($user1->deleteGarden("Delete me"));
            echo $user1;
        ?>
    </article>
    <article>
        <h2>Clase Garden:</h2>
        <p>Representa a un jardín, al cual nos referimos como un grupo de tareas y quehaceres que estarán representadas por distintas plantas. Un jardín se compone de los siguientes parámetros</p>
        <!-- TODO: incertar aquí el gráfico UML de GARDEN-->
        <p>Un ejemplo de jardín puede ser este:</p>
        <?php
            echo $exampleGarden;
        ?>
        <p>Ahora que sabemos que es un jardín, procedemos a explicar los métodos que tiene disponible, empecemos con añadir plantas al Jardín con el método <code>addPlant()</code> En este caso, vamos a usar el primer jardín del usuario Gato, y vamos a darle quehaceres</p>
        <?php
            $phpPlant = new HarvestPlant("Práctica PHP", "Crear aplicación web con PHP", "/resources/assets/silencePrincess.jpg", time(), strtotime("12 November 2025"));
            echo printBool($exampleGarden->addPlant($phpPlant));

            echo $phpPlant;
        ?>
        <p>¡Listo!, debemos tomar en cuenta además que no pueden existir dos plantas con el mismo nombre dentro de un mismo jardín</p>
        <?php
            $repeatedPlant = $exampleGarden->addPlant(new HarvestPlant("Práctica PHP", "Crear aplicación web con PHP", "/resources/assets/silencePrincess.jpg", time(), strtotime("12 November 2025")));

            echo printBool($repeatedPlant);
        ?>
        <p>ahora, al igual que con los métodos para buscar , cambiar nombre, elimiar, etc estos aplican igual a las plantas, veamos esos métodos</p>
        
        <div class="flex-container">
            <div class="flex-contend">
                <p><code>findPlant()</code></p>
                <?php
                    $phpPlant = $exampleGarden->findPlant("Práctica PHP");

                    echo $phpPlant;
                ?>
            </div>
            <div class="flex-contend">
                <p><code>plantExist()</code></p>
                <p>¿Existe la planta "Práctica PHP"?</p>
                <?php
                    echo printBool($exampleGarden->plantExist("Práctica PHP"));
                ?>
            </div>
            <div class="flex-contend">
                <p><code>changePlantTitle()</code></p>
                <?php
                    echo $phpPlant;
                    echo printBool($exampleGarden->changePlantTitle("Práctica PHP", "PHP"));
                    echo $phpPlant;
                ?>
            </div>
            <div class="flex-contend">
                <p><code>deletePlant()</code></p>
                <?php
                    echo printBool($exampleGarden->deletePlant("PHP"));
                ?>
            </div>
        </div>

        <p>Además de eso también tenemos métodos para encontrar y eliminar plantas que se hayan marchitado, por marchitado nos referimos a aquellas que han perdido todos sus puntos de salud, por ende ya no se puede recuperar la planta, más adelante explicaremos como se pierden los puntos de salud por cada tipo de planta, por ahora, crearemos 3 plantas con 0 puntos de salud</p>

        <?php
            $exampleGarden->addPlant(
                new HarvestPlant(
                    "Práctica PHP", 
                    "Crear aplicación web con PHP", 
                    "/resources/assets/silencePrincess.jpg", 
                    time(), 
                    strtotime("13 November 2025")));
            $exampleGarden->addPlant(
                new HarvestPlant(
                    "Tarea incompleta",
                     "Tarea incompleta", 
                     "/resources/assets/witheredPlant.png", strtotime("1 November 2025"), strtotime("10 November 2025"), 
                     false, 
                     0));
            $exampleGarden->addPlant(
                new FruitTree(
                    "Rutina sin hacer", 
                    "Rutina sin hacer", 
                    "/resources/assets/witheredPlant.png", strtotime("1 November 2025"), 604800, 
                    strtotime("1 November 2025"), 
                    0, 
                    [], 
                    false, 
                    false, 
                    0));
            $exampleGarden->addPlant(
                new DecorativePlant(
                    "Habito sin adquirir",
                    "Habito sin adquirir",
                    "/resources/assets/witheredPlant.png",
                    strtotime("1 November 2025"),
                    86400,
                    0,
                    0,
                    0,
                    false,
                    0,
                    0));

            echo $exampleGarden;
        ?>
        <p>Ahora, vamos a usar la función <code>findWitheredPlants()</code> para pasar las pantas desatendidas al array correspondiente</p>
        <?php 
            $exampleGarden->findWitheredPlants();
            echo $exampleGarden;
        ?>
        <p>Se pueden eliminar las plantas marchitas con la función <code>clearWitheredPlants()</code></p>
        <?php 
            $exampleGarden->clearWitheredPlants();
            echo $exampleGarden;
        ?>
        <p>Por último, si el usuario quiere cambiar los aires del jardín, puede cambiar el ambiente con la función <code>changeEnvironment()</code></p>
        <?php 
            $exampleGarden->changeEnvironment("/resources/assets/cozyGreenhouse.jpg");
            echo $exampleGarden;
        ?>
    </article>
    <article>
        <h2>Clase abstracta Plant</h2>
        <p>Es la base de las tareas que van a realizarse</p>
        <!--TODO incertar UML de Plant-->
        <p>De esta clase se heredarán tres objetos:</p>
        <ul>
            <li>HarvestPlant: para tareas que solo se deben hacer una vez</li>
            <li>FruitTree: para aquellas tareas que se deben ir haciendo durante un cierto tiempo</li>
            <li>DecorativePlant: para hacer un seguimiento de hábitos</li>
        </ul>
        <p>Las tres plantas tienen los mismos métodos, pero interactuan diferente entre cada tipo de planta, vamos a crear estas tres tareas: </p>
        <?php 
            $harvestExample = new HarvestPlant(
                    "Práctica PHP", 
                    "Crear aplicación web con PHP", 
                    "/resources/assets/greenTomato.png", 
                    time(), 
                    strtotime("14 November 2025"));

            $fruitTreeExample = new FruitTree(
                "Proyecto Empresa",
                "Entrega semanal de las fases del proyecto",
                "/resources/assets/greenTomato.png",
                time(),
                604800,
                strtotime("+1 week"),
                strtotime("+4 week")
            );
            $decorativeExample = new DecorativePlant(
                "Hacer ejercicio una hora",
                "Hacer ejercicio",
                "/resources/assets/greenTomato.png",
                time(),
                86400,
                strtotime("+1 day")
            );
        ?>
        <div class="flex-contend">
            <?php 
                echo $harvestExample;
                echo $fruitTreeExample;
                echo $decorativeExample;
            ?>
        </div>
        <p>Y ahora que tenemos todos los objetos, vamos a explorar como interactuan los métodos entre ellos</p>
        <div class="flex-container">
            <div class="flex-contend">
                <p><code>completeOrReopenTask()</code> para abrir de nuevo o cerrar las tareas, tiene efectos diferentes en cada tipo de planta</p>
                <?php 
                    $harvestExample->completeOrReopenTask(true);
                    echo $harvestExample;
                    $fruitTreeExample->completeOrReopenTask(true);
                    echo $fruitTreeExample;
                    $decorativeExample->completeOrReopenTask(true);
                    echo $decorativeExample;
                ?>
                <p>Podemos apreciar que se han actualizado varios valores en los objetos de FruitTree y DecorativePlant</p>
            </div>
            <div class="flex-contend">
                <p><code>calculateHealthPoints()</code> para realizar el calculo de la salud de las plantas, además esta función actualiza otros valores como la racha en DecorativePlant</p>
                <p>Conste que este método ya se activa de por sí, si se completa la tarea, pero solo se debe accionar una vez al día por planta, pero por motivos de demostraciones, vamos a ejecutarlo de nuevo</p>
                <?php 
                    $harvestExample->calculateHealthPoints();
                    echo $harvestExample;
                    $fruitTreeExample->calculateHealthPoints();
                    echo $fruitTreeExample;
                    $decorativeExample->calculateHealthPoints();
                    echo $decorativeExample;
                ?>
            </div>
        </div>
    </article>
</body>
</html>