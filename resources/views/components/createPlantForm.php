<div class="card p-4 col-12">
    <div class="card-body">
        <h2 class="card-title">Crea tu planta:</h2>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Título de la tarea</label>
                <input type="text" name="title" id="title" class="form-control <?= (!empty($errorTitle)) ? "is-invalid" : ""?>" <?= (isset($_POST['title']) && isset($error)) ? "value=\"".$_POST['title']."\" " : ""?>required>
                <?= (!empty($errorTitle)) ? $errorTitle : "" ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción de la tarea:</label>
                <textarea name="description" id="description" class="form-control" <?= (isset($_POST['description']) && isset($error)) ? "value=\"".$_POST['description']."\" " : ""?>></textarea>
            </div>
            <div class="mb-3">
                <label for="deadLine" class="form-label">Fecha límite de la tarea</label>
                <input type="date" name="deadLine" id="deadLine" class="form-control <?= (!empty($errorDeadLine)) ? "is-invalid" : ""?>" min="<?= gmdate("Y-m-d", time()) ?>" <?= (isset($_POST['deadLine']) && isset($error)) ? "value=\"".$_POST['deadLine']."\" " : ""?>>
            </div>
            <div class="mb-3 justify-content-end align-content-end">
                <input type="submit" value="Crear Planta" class="btn btn-success">
            </div>
        </form>
    </card>
</div>