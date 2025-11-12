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
    <?php
        $user1 = new User("Gato", "password", "gato@pomodorogarden.com");
        $user2 = new User("Perrito", "password", "perrito@pomodorogarden.com");
        $user3 = new User("Pedro", "password", "pedro@pomodorogarden.com");

        var_dump ($user1->createGarden("Tomates", "cozy"));

        var_dump($user1->getGardens()[0]->addPlant(new HarvestPlant("Práctica PHP", "Detalles en el aula virtual", $_SERVER['DOCUMENT_ROOT'] . "/resources/assets/greenTomato.png", time(), strtotime("+2 week"))));
        
        echo printForHtml($user1);

        
    ?>
</body>
</html>