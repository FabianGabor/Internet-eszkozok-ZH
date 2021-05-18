<?php
require_once('../config/db.php');

if (!AUTH) return;

if (empty($_POST['vizterulet']) ||
    empty($_POST['halfajta']) ||
    empty($_POST['halsuly']) ||
    empty($_POST['fogasdatum']) ||
    !isset($_FILES['img'])) {
    print json_encode(['uzenet' => 'Kotelezo mezok hianyoznak', 'class' => 'alert alert-danger']);
    return;
}
if ($_FILES['img']['error'] !== 0) {
    print json_encode(['uzenet' => 'Hibas allomany feltoltes', 'class' => 'alert alert-danger']);
    return;
}

if (
    $_FILES['img']['error'] !== 0 ||
    ($_FILES['img']['type'] != 'image/jpeg' &&
        $_FILES['img']['type'] != 'image/png')
) {
    print json_encode(['uzenet' => 'Hibas allomany tipus!', 'class' => 'alert alert-danger']);
    return;
}

// XSS
if (!empty($dbcon)) {
    foreach ($_POST as $key => $value) {
        $$key = htmlspecialchars($dbcon->real_escape_string($value));
    }
}
$img_filename = $_FILES['img']['name'];
$tmp_name     = $_FILES['img']['tmp_name'];

var_dump($img_filename);
var_dump($tmp_name);

$sql = "INSERT INTO {$db}.fogasok(userid, vizterulet, halfajta, halsuly, fogasdatum, img) 
        VALUES ('{$_SESSION['felhasznalo']['id']}', '{$vizterulet}', '{$halfajta}', '{$halsuly}', '{$fogasdatum}', '{$img_filename}')";

if ($dbcon->query($sql)) {
    $save_path = GALLERY_PATH . $_SESSION['felhasznalo']['id'] . '/fogasok/';
    mkdir(GALLERY_PATH . $_SESSION['felhasznalo']['id']);
    mkdir($save_path);
    // TODO: chown & chmod media/

    move_uploaded_file($tmp_name, $save_path . $img_filename);
    print json_encode(['uzenet' => 'Sikeres feltoltes!', 'class' => 'alert alert-success']);
}

print $dbcon->error;