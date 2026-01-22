<?php

session_start();
$_SESSION = [];
session_destroy();
setcookie('stay-connected', "", time() - 3600, "/");
header("Location: logIn.php");
exit();