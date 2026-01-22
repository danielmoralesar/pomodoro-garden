<div class="card p-4">
    <div class="card-body">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de usuario:</label>
                <input type="text" name="name" id="name" class="form-control <?= !empty($errorName) ? "is-invalid" : "" ?>" <?= isset($_POST['name']) ? "value=\"".$_POST['name']."\" " : ""?> required>
                <?= !empty($errorName) ? $errorName : ""?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Tu email:</label>
                <input type="email" name="email" id="email" class="form-control <?= !empty($errorEmail) ? "is-invalid" : "" ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" <?= isset($_POST['email']) ? "value=\"".$_POST['email']."\" " : ""?> required>
                <?= !empty($errorEmail) ? $errorEmail : ""?>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Una contraseña:</label>
                <input type="password" name="pass" id="pass" class="form-control <?= !empty($errorPass) ? "is-invalid" : "" ?>" minlength="8" required>
                <?= !empty($errorPass) ? $errorPass : ""?>
            </div>
            <div class="mb-3">
                <label for="chPass" class="form-label">Repetir contraseña:</label>
                <input type="password" name="chPass" id="chPass" class="form-control <?= !empty($errorPass) ? "is-invalid" : "" ?>" minlength="8" required>
                <?= !empty($errorPass) ? $errorPass : ""?>
            </div>
            <div class="mb-3">
                <input type="submit" class="form-control btn-outline-light" value="Crear cuenta">
            </div>
            
            <p class="text-muted">¿ya tienes cuenta? <a class="text-black" href="/public/logIn.php">inicia sesión</a></p>
        </form>
    </div>
</div>