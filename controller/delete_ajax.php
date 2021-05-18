<?php
require_once('../config/db.php');

$id = $_GET['id'];

if ($_POST['jelszo'] != $_POST['jelszo_ujra']) {
    $msg = "Jelszavak nem egyeznek";
    print json_encode(['uzenet'=>$msg, 'class'=>'alert alert-danger']);
    return false;
}

// XSS SQL
foreach ($_POST as $key => $value) {
    if (!empty($dbcon)) {
        $$key = htmlspecialchars($dbcon->real_escape_string($value));
    }
}

if (!empty($db)
    //&& !empty($userTable)
    ) {
    $sql = "DELETE FROM {$db}.fogasok ";
}

$jelszo = $_POST['jelszo'];
$sql = $sql . "WHERE `id`= {$id} LIMIT 1";

if ($dbcon->query($sql)) {
    print json_encode(['uzenet'=>"Sikeres törlés", 'class'=>'alert alert-success fade show', 'id'=>$id]);
} else {
    print json_encode(['uzenet' => "$dbcon->error SQL: $sql", 'class' => 'alert alert-danger show']);
}

$dbcon->close();