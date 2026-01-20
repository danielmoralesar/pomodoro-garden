<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
    $email = "";
    $error = false;

    if(isset($_COOKIE['stay-connected'])){
        $_SESSION['email'] = $_COOKIE['stay-connected'];
        $_SESSION['origin'] = "login";
        header("Location: index.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";
        $email = filter_var(secure($_POST['email']), FILTER_VALIDATE_EMAIL);
        $error = !$email ? true : false;
        var_dump($error);
        var_dump($email);

        if (!$error){
            var_dump("primer pase");
            if (UserDAO::logIn($email, secure($_POST['pass']))){
                if (isset($_POST['stay-connected'])){
                    setcookie("stay-connected", $email, time()+60*60*24*30, "/");
                }
                $_SESSION['user'] = UserDAO::select("email", $email);
                $_SESSION['origin'] = "login";
                header("Location: index.php");
                exit();
            } else {
                $error = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia sesión - Pomodoro Garden</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div>
        <div>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/resources/views/components/logInForm.php";?>
        </div>
    </div>
</body>
</html>