<nav class="navbar navbar-expand-lg navbar-light bg-light ">
    <div class="container">
        <a href="index.php" class="navbar-brand">🍅</a>
        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?= activeHeader("index")?>">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="plants.php" class="nav-link <?= activeHeader("plants")?>">Todas tus plantas</a>
                </li>
                <li class="nav-item">
                    <a href="closeSession.php" class="btn btn-outline-danger">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>