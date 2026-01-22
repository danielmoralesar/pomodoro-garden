<div class="card p-4">
    <div class="card-body">
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Tu email</label>
                <input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" <?= isset($_POST['email']) ? "value=\"".$_POST['email']."\" " : ""?> required>
            </div>    
            <div class="mb-3">
                <label for="pass" class="form-label">Contraseña</label>
                <input type="password" name="pass" id="pass" class="form-control" minlength="8" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" id="stay-connected" class="form-check-input" name="stay-connected">
                <label for="stay-connected" class="form-checkbox-label">Quiero seguir conectado</label>
            </div>
            <?php
                echo $error ? printForHtml("Hay un error en tu contraseña, email, o quizá no tengas cuenta", "div", "class", "text-danger mb-3") : "";

                if (isset(($_SESSION['accJustCreated']))){
                    echo printForHtml("¡Cuenta creada con éxito!", "div", "class", "text-success mb-3");
                    unset($_SESSION['accJustCreated']);
                }
            ?>
            <div class="mb-3">
                <input type="submit" class="form-control btn-outline-light" value="Iniciar sesión">
            </div>
            <p class="text-muted">¿no tienes cuenta? <a class="text-black" href="/public/signUp.php">crea una</a></p>
        </form>
    </div>
</div>