<?php
require_once("../config/db.php");
if (!AUTH) return;

if (!isset($_GET['galeria_kep'])) {
    return;
}

if (isset($db)) {
    $sql = "SELECT * FROM {$db}.galeria_kepek WHERE galeria_kep_id='{$_GET['galeria_kep']}'";
}
$query = $dbcon->query($sql);

print $dbcon->error;

if ($query->num_rows) {
    $kep = $query->fetch_assoc();
    header('Content-Type: ' . $kep['mime']);
    print file_get_contents(GALLERY_PATH . $kep['galeria_id'] . '/' . $kep['kep_hash_neve']);
}