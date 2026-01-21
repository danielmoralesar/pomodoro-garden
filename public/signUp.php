<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
    $name = $email = $pass = "";
    $error = false;
    $errorMsg = false;

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";
        $email = filter_var(secure($_POST['email']), FILTER_VALIDATE_EMAIL);
        $pass = secure($_POST['pass']) == secure($_POST['chPass']) ? hashPass(secure($_POST['pass'])) : false;
        $name = secure($_POST['name']);

        $errorMsg = empty($email) ? printForHtml("Debes ingresar un mail", "li") : false;
        $errorMsg .= empty($name) ? printForHtml("Debes ingresar un nombre de usuario", "li") : "";
        $errorMsg .= empty($pass) ? printForHtml("Las contraseñas no coinciden", "li") : "";

        $error = $errorMsg ? true : false;

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
                $errorMsg = $previousEmailExists ? printForHtml("Ya existe una cuenta con ese email", "ul") : "";
                $errorMsg .= $previousUserExists ? printForHtml("Ya existe un usuario con ese nombre", "ul") : "";
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