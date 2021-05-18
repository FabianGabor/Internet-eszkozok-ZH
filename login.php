<?php
//session_destroy();
if (isset($_SESSION['felhasznalo'])) {
    var_dump($_SESSION);
    return;
}
?>

<form action="controller/login.php" method="post">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'] ?>
        </div>
        <?php
        unset($_SESSION['error']);
    endif; ?>
    <div class="form-group">
        <label for="">Email cím</label>
        <input type="text" name="felhasznalonev" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="">Jelszo</label>
        <input type="password" name="jelszo" class="form-control" required>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" name="emlekezz" class="form-check-input" id="emlekezz" value="1">
            <label for="emlekezz" class="form-check-label">Emlekezz ram</label>
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Belépés</button>
    </div>
</form>