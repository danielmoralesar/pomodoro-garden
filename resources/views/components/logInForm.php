<div>
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
        <label for="pass">Tu email</label>
        <input type="email" name="email" id="email" required>
        <label for="pass">Contraseña</label>
        <input type="password" name="pass" id="pass" required>
        <input type="checkbox" id="stay-connected" name="stay-connected">
        <label for="stay-connected">Quiero seguir conectado</label>
        <input type="submit" value="Iniciar sesión">
        <p>¿no tienes cuenta? <a href="/public/signUp.php">click aquí</a></p>
    </form>
</div>