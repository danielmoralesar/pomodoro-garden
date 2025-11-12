<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php"
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomodoro Garden</title>
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
            $user1 = new User("Gato", "password", "gato@pomodorogarden.com");

            echo $user1;
        ?>
        <p>Ahora que el usuario se ha creado, vamos a crearle un jardín con el método <code>createGarden()</code> se le pasarán como parámetros, el nombre del jardín, y la Path del ambiente del jardín</p>
        <?php 
            var_dump($user1->createGarden("TO-DO list", "path"));
        ?>
        <p>Hemos recibido un true como respuesta, eso significa que el jardín se ha creado con éxito.</p>
        <?php
            echo $user1;
        ?>
        <p>Pero, ¿qué pasaría si creamos de nuevo otro jardín con el mísmo título?</p>
        <?php 
            var_dump($user1->createGarden("TO-DO list", "path"));
        ?>
        <p>Recibiremos un false, como se puede ver, no será posible tener jardines con los mísmos títulos, ya que identificaremos los jardines mediante estos, cuando tengamos la base de datos, estos serán la clave primaria. Podemos realizar busquedas para ver si existe el jardín antes de crearlo con el siguiente método, <code>gardenExist()</code></p>
        <?php 
            var_dump($user1->gardenExist("TO-DO list"));
        ?>
        <p>¿Y si queremos cambiarle el nombre al jardín? Podemos hacerlo con la función <code>changeGardenTitle()</code></p>
        <?php 
            var_dump($user1->changeGardenTitle("TO-DO list", "Pomodoro Project"));
            echo $user1;
        ?>
        <p>Listo, dejaremos creado los dos jardines para posteriores pruebas</p>
        <p>Otro método que puede ayudar al usuarie, puede ser el método <code>findGarden()</code>, que como su nombre indica, busca y devuelve un objeto Jardín</p>
        <?php 
            $user1->createGarden("TO-DO list", "path");
            $user1->createGarden("Delete me", "path");
            echo $user1;
            $users1Garden = $user1->findGarden("TO-DO list");
            echo $users1Garden;
        ?>
        <p>Ahora, digamos que un usuarie quiere eliminar un jardin, para eso tenemos el método <code>deleteGarden()</code>, al igual que los métodos anteriores devuelve true o false dependiendo si se logró eliminar el jardín</p>
        <?php 
            var_dump($user1->deleteGarden("Delete me"));
            echo $user1;
        ?>
    </article>
    <article>
        <h2>Clase Garden:</h2>
        <p>Representa a un jardín, al cual nos referimos como un grupo de tareas y quehaceres que estarán representadas por distintas plantas. Un jardín se compone de los siguientes parámetros</p>
        <!-- TODO: incertar aquí el gráfico UML de GARDEN-->
        <p>Ahora que sabemos que es un jardín, procedemos a explicar los métodos que tiene disponible, empecemos con añadir plantas al Jardín con el método <code>addPlant()</code></p>
        <?php 
            var_dump($users1Garden->addPlant(new HarvestPlant("Práctica PHP", "Crear aplicación web con PHP", "path/img", time(), strtotime("12 November 2025"))));

            // TODO check this
            echo $user1->getGardens()[0];
        ?>
    </article>
</body>
</html>