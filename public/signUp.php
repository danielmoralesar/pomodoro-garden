<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
    $name = $email = $pass = "";
    $error = false;
    $errorEmail = $errorName = $errorPass = false;

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";
        $email = filter_var(secure($_POST['email']), FILTER_VALIDATE_EMAIL);
        $pass = secure($_POST['pass']) == secure($_POST['chPass']) ? hashPass(secure($_POST['pass'])) : false;
        $name = secure($_POST['name']);

        $errorEmail = empty($email) ? printForHtml("Debes ingresar un mail válido", "div", "class", "invalid-feedback") : false;
        $errorName .= empty($name) ? printForHtml("Debes ingresar un nombre de usuario", "div", "class", "invalid-feedback") : false;
        $errorPass .= empty($pass) ? printForHtml("Las contraseñas no coinciden", "div", "class", "invalid-feedback") : false;

        $error = $errorEmail || $errorName || $errorPass ? true : false;

        if (!$error){
            $previousEmailExists = UserDAO::select($email, "email") ? true : false;
            $previousUserExists = UserDAO::select($name, "name") ? true : false;
            if (!$previousEmailExists && !$previousUserExists){
                $user = new User($name, $email, $pass);
                UserDAO::create($user);

                if($user->getId() > -1){
                    $_SESSION['accJustCreated'] = true;
                    $_SESSION['origin'] = "signup";
                    header("Location: logIn.php");
                    exit();
                }
            } else {
                $error = true;
                $errorEmail = $previousEmailExists ? printForHtml("Ya existe una cuenta con ese email", "div", "class", "invalid-feedback") : false;
                $errorName .= $previousUserExists ? printForHtml("Ya existe un usuario con ese nombre", "div", "class", "invalid-feedback") : false;
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
    <main class="container">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/views/components/signUpForm.php";?>
        </div>
    </main>
</body>
</html>