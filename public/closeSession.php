<?php

session_start();
// TODO borrar sesión y eliminar cookies

unset($_SESSION);

session_destroy();

setcookie('stay-connected', "", time() - 3600, "/");

header("Location: logIn.php");
exit();