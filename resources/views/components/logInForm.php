<div class="col">
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
        <label for="pass">Tu email</label>
        <input type="email" name="email" id="email" required>
        <label for="pass">Contraseña</label>
        <input type="password" name="pass" id="pass" required>
        <input type="submit" value="Iniciar sesión">
        <p>¿no tienes cuenta? click aquí</p>
    </form>
</div>