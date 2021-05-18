<?php
require_once('../config/db.php');

if (isset($_POST['vezeteknev'])) {
    if (
        empty($_POST['email'])          ||
        empty($_POST['jelszo'])         ||
        empty($_POST['jelszo_ujra'])    ||
        !isset($_POST['gdpr'])
    ) {
        print json_encode(['uzenet'=>"Nincsenek kitöltve a kötelező mezők", 'class'=>'alert alert-danger']);
        return false;
    }
}

if ($_POST['jelszo'] != $_POST['jelszo_ujra']) {
    //$msg = "Jelszavak nem egyeznek";
    print json_encode(['uzenet'=>"Jelszavak nem egyeznek", 'class'=>'alert alert-danger']);
    return false;
}

// XSS SQL
if (!empty($dbcon)) {
    foreach ($_POST as $key => $value) {
        $$key = htmlspecialchars($dbcon->real_escape_string($value));
    }
}
if (!empty($jelszo) && !empty($salt)) {
    $jelszo = hash('sha3-512', $jelszo . $salt);
}

if (!empty($db) && !empty($userTable)) {
    $sql = "INSERT INTO {$db}.{$userTable} (vezeteknev, keresztnev, email, jelszo) VALUES ('{$vezeteknev}', '{$keresztnev}', '{$email}', '{$jelszo}')";
}

if ($dbcon->query($sql)) {
    print json_encode(['uzenet'=>"Sikeres adatfeltoltes", 'class'=>'alert alert-success fade show']);
} else {
    print json_encode(['uzenet' => "$dbcon->error", 'class' => 'alert alert-danger fade show']);
}

$dbcon->close();