<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">LOGO</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <!-- fooldalon van regisztralas
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=register">Regisztráció</a>
            </li>
            -->
            <!-- nem kell
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=users">Felhasználók</a>
            </li>
            -->
            <?php if (AUTH): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=gallery">Galéria</a>
                </li>
            <?php endif; ?>
            <?php if (!isset($_SESSION['felhasznalo'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=login">Belépés</a>
                </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['felhasznalo'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?logout">Kilépés</a>
                </li>
            <?php endif; ?>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>