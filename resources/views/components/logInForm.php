<div>
    <div class="col-12 <?= $error?'':'d-none'?>">
        <p>Hay un error en tu email o contraseña</p>
    </div>
    <div class="col-12 <?=isset($_SESSION['accJustCreated'])?'':'d-none'?>">
        <p>¡Haz creado tu cuenta con éxito!</p>
    </div>
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
        <label for="pass">Tu email</label>
        <input type="email" name="email" id="email" required>
        <label for="pass">Contraseña</label>
        <input type="password" name="pass" id="pass" required>
        <input type="checkbox" id="stay-connected" name="stay-connected">
        <label for="stay-connected">Quiero seguir conectado</label>
        <input type="submit" value="Iniciar sesión">
        <p>¿no tienes cuenta? <a href="/public/signUp.php">crea una</a></p>
    </form>
</div>