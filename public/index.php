<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php"
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
        $user = new User("Gato", "password", "gato@pomodorogarden.com");

        $user->createGarden("Tomates", "cozy");
        
        echo printForHtml($user);

        echo printForHtml(var_dump($user->deleteGarden("apples")));
    ?>
</body>
</html>