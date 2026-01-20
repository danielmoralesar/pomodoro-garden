<?php
    session_start();
    $mail = $pass = "";
    $error = false;

    if(isset($_COOKIE['stay-connected'])){
        $_SESSION['email'] = $_COOKIE['stay-connected'];
        $_SESSION['origin'] = "login";
        header("Location: index.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        include $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
        $mail = $error = filter_var(secure($_POST['email']), FILTER_VALIDATE_EMAIL);
        $pass = hashPass($_POST['pass']);

        if (!$error){
            if (UserDAO::logIn($email, $pass) = $error){
                if (isset($_POST['stay-connected'])){
                    setcookie("stay-connected", $mail, time()+60*60*24*30, "/");
                }
                $_SESSION['user'] = UserDAO::select("email", $mail);
                $_SESSION['origin'] = "login";
                header("Location: index.php");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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