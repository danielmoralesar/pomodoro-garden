<div>
    <div class="col-12 <?= !$error ?'d-none' : ''?>">
        <?=!empty($errorMsg) ? printForHtml($errorMsg, "ul") : ""?>
    </div>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="name">Nombre de usuario</label>
        <input type="text" name="name" id="name" required>
        <label for="email">tu email</label>
        <input type="email" name="email" id="email" required>
        <label for="pass">una contraseña</label>
        <input type="password" name="pass" id="pass" required>
        <label for="chPass">repite la contraseña</label>
        <input type="password" name="chPass" id="chPass" require>
        <input type="submit" value="Crear cuenta">
        <p>¿ya tienes cuenta? <a href="/public/logIn.php">inicia sesión</a></p>
    </form>
</div>