<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="bi bi-journal-bookmark"></i> Horgász</a>
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
                <!-- ez is felesleges, ha belep, akkor a naplo a fooldalon lesz
                <?php //if (AUTH): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=horgasznaplo">Horgásznapló</a>
                    </li>
                <?php //endif; ?>
                -->
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
        </div>
    </div>
</nav>