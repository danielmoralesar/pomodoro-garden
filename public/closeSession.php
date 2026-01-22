<?php

session_start();
unset($_SESSION);
session_destroy();
setcookie('stay-connected', "", time() - 3600, "/");
header("Location: logIn.php");
exit();