<?php
require_once('../config/db.php');

if (isset($_POST['felhasznalonev'])) {
    // TODO: kotelezo mezok vizsgalata

    // sql injection
    if (!empty($dbcon)) {
        foreach ($_POST as $key => $val) {
            $$key = $dbcon->real_escape_string($val);
        }
    }

    if (!empty($jelszo) && !empty($salt)) {
        $jelszo = hash('sha3-512', $jelszo . $salt);

        $sql = "SELECT * FROM {$db}.{$userTable} WHERE {$userTable}.email='{$felhasznalonev}' AND {$userTable}.jelszo='{$jelszo}'";
        $query = $dbcon->query($sql);
        print $dbcon->error;
    }

    if ($query->num_rows) {
        $_SESSION['felhasznalo'] = $query->fetch_assoc();
        $_SESSION['ok'] = "Sikeres belépés";

        if (isset($_POST['emlekezz'])) {
            $remember_token = hash('sha3-512', uniqid());
            setcookie('rememberme', $remember_token, time() + $cookie_expires, '/');
            $sql = "UPDATE {$db}.{$userTable} SET {$userTable}.remember_token='{$remember_token}' WHERE {$userTable}.id='{$_SESSION['felhasznalo']['id']}'";
            $dbcon->query($sql);
        }

        header("Location: ../index.php");
    } else {
        $_SESSION['error'] = "Sikertelen belépés";
        header("Location: ../index.php?page=login");
    }
}