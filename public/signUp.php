<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
    $name = $email = $pass = "";
    $error = false;
    $errorMsg = false;

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";
        $email = filter_var(secure($_POST['email']), FILTER_VALIDATE_EMAIL);
        $pass = $_POST['pass'] === $_POST['chPass'] ? hashPass(secure($_POST['pass'])) : false;
        $name = secure($_POST['name']);

        $errorMsg = $email ? printForHtml("Debes ingresar un mail", "li") : false;
        $errorMsg .= empty($name) ? printForHtml("Debes ingresar un nombre de usuario", "li") : $errorMsg;
        $errorMsg .= $pass ? printForHtml("Las contraseñas no coinciden", "li") : $errorMsg;

        $error = $errorMsg ? true : false;

        if ($error){
            if (!UserDAO::select($email, "email") && !UserDAO::select($name, "name")){
                $user = new User($name, $email, $pass);
                UserDAO::create($user);

                if($user->getId() > -1){
                    $_SESSION['accJustCreated'] = true;
                    $_SESSION['origin'] = "signup";
                    header("Location: logIn.php");
                    exit();
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - Pomodoro Garden</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div>
        <div>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/views/components/signUpForm.php";?>
        </div>
    </div>
</body>
</html>