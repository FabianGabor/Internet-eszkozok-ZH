<?php
require_once('../config/db.php');

function trim_value(&$value) {
    $value = trim($value);
}
array_filter($_POST, 'trim_value');

function filter_date(&$value) {
    try {
        $datetime = new DateTime($value);
        $value = $datetime->format('Y-m-d');
        return $value;
    } catch(Exception $e) {
        echo "Rossz dátum formátum";
        return false;
    }
}

if (isset($_POST['vezeteknev'])) {
    if (
        empty($_POST['email'])          ||
        empty($_POST['jelszo'])         ||
        empty($_POST['jelszo_ujra'])
        // || !isset($_POST['gdpr'])
    ) {
        $msg = 'Nincsenek kitöltve a kötelező mezők';
        //header("Location: index.php");
        print $msg;
        return false;
    }
}

if ($_POST['jelszo'] != $_POST['jelszo_ujra']) {
    $msg = "Jelszavak nem egyeznek";
    print $msg;
    return false;
}

// XSS SQL
foreach ($_POST as $key => $value) {
    if (!empty($dbcon)) {
        $$key = htmlspecialchars($dbcon->real_escape_string($value));
    } else {
        return false;
    }
}
$postfilter =    // set up the filters to be used with the trimmed post array
    array(
        'elotag'        =>    array('filter' => FILTER_SANITIZE_STRING),    // removes tags. formatting code is encoded -- add nl2br() when displaying
        'vezeteknev'    =>    array('filter' => FILTER_SANITIZE_STRING),    // removes tags. formatting code is encoded -- add nl2br() when displaying
        'keresztnev'    =>    array('filter' => FILTER_SANITIZE_STRING),    // removes tags. formatting code is encoded -- add nl2br() when displaying
        'allandoLakcim' =>    array('filter' => FILTER_SANITIZE_STRING),    // removes tags. formatting code is encoded -- add nl2br() when displaying
        'ertesitesiCim' =>    array('filter' => FILTER_SANITIZE_STRING),    // removes tags. formatting code is encoded -- add nl2br() when displaying
        //'szuletesiIdo'  =>    array('filter' => FILTER_SANITIZE_STRING),  // filter_date()
        'szuletesiHely' =>    array('filter' => FILTER_SANITIZE_STRING, 'flags' => !FILTER_FLAG_STRIP_LOW),    // removes tags. formatting code is encoded -- add nl2br() when displaying
        'anyjaNeve'     =>    array('filter' => FILTER_SANITIZE_STRING, 'flags' => !FILTER_FLAG_STRIP_LOW),    // removes tags. formatting code is encoded -- add nl2br() when displaying
        'telefon'       =>    array('filter' => FILTER_SANITIZE_NUMBER_INT, 'flags' => !FILTER_FLAG_STRIP_LOW),    // removes tags. formatting code is encoded -- add nl2br() when displaying
        'email'         =>    array('filter' => FILTER_SANITIZE_EMAIL),    // removes tags. formatting code is encoded -- add nl2br() when displaying
    );
$sanitized_POST = filter_var_array($_POST, $postfilter);    // must be referenced via a variable which is now an array that takes the place of $_POST[]
echo (nl2br($sanitized_POST['user_tasks']));    //-- use nl2br() upon output like so, for the ['user_tasks'] array value so that the newlines are formatted, since this is our HTML <textarea> field and we want to maintain newlines
filter_date($_POST['datum']);
if (!empty($jelszo) && !empty($salt)) {
    $jelszo = hash('sha3-512', $jelszo.$salt);
}
$_POST = $sanitized_POST;

$table = "jelentesek";
$cols = "elotag, vezeteknev, keresztnev, allandoLakcim, ertesitesiCim, szuletesiIdo, szuletesiHely, anyjaNeve, telefon, email, jelszo";
$vals = '\'$elotag\', \'$vezeteknev\', \'$keresztnev\', \'$allandoLakcim\', \'$ertesitesiCim\', \'$szuletesiIdo\', \'$szuletesiHely\', \'$nem\', \'$anyjaNeve\', \'$telefon\', \'$email\', \'$jelszo\'';

$sql = "INSERT INTO $table ($cols) VALUES ($vals)";

if (!empty($dbcon)) {
    if ($dbcon->query($sql)) {
        print "Sikeres mentés adatbázisba!" . "<br>";
    } else {
        var_dump($dbcon->error_list);
    }
} else {
    print "Adatbázis kapcsolódás hiba";
}