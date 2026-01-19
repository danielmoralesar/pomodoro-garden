<?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";

        $user = new User("testing2", "testing@gmail.com", "SuperSecurePassword");
        UserDAO::create($user);
        echo $user;
        $sameUser = new User("testing2", "testing@gmail.com", "SuperSecurePassword");
        var_dump(UserDAO::create($sameUser));
        echo "<hr>";

        echo printForHtml("Búsqueda por name");
        echo UserDAO::select("testing2", "name");
        echo printForHtml("Búsqueda por email");
        echo UserDAO::select("testing@gmail.com", "email");
        echo printForHtml("Búsqueda por id");
        $userId = $user->getId();
        echo UserDAO::select($userId, "id");
        echo printForHtml("Búsqueda con dato erroneo");
        var_dump(UserDAO::select("true", "true"));
        echo "<hr>";

        echo printForHtml("Update sin cambios");
        var_dump(UserDAO::update( $user));
        echo "<hr>";
        var_dump($user);
        $user = UserDAO::select($userId, "id");
        echo printForHtml("Update email");
        $user->setEmail("newemail@gmail.com");
        echo UserDAO::update($user);
        echo printForHtml("Update name");
        $user->setName("Admin");
        echo UserDAO::update($user);
        echo printForHtml("Update name");
        $user->setName("Admin");
        echo UserDAO::update($user);
        echo printForHtml("Update password");
        $user->setPassword("PasswordSuperSecure");
        echo UserDAO::update($user);
        echo "<hr>";

        echo printForHtml("Inicio de sesión");
        echo printForHtml("credenciales correctas:");
        var_dump(UserDAO::logIn("newemail@gmail.com", "PasswordSuperSecure"));
        echo printForHtml("contraseña incorrecta:");
        var_dump(UserDAO::logIn("newemail@gmail.com", "Password"));
        echo printForHtml("email incorrecto:");
        var_dump(UserDAO::logIn("newemail@gmail.com", "Password"));
        echo "<hr>";

        echo printForHtml("eliminar usuario");
        var_dump(UserDAO::delete($user));