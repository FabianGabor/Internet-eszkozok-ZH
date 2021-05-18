<?php
/*
 * Fábián Gábor
 * CXNU8T
 * https://github.com/FabianGabor/Internet-eszkozok-ZH
 */
?>
<?php
require_once("config/db.php");
?>
<!doctype html>
<html class="no-js" lang="hu">

<head>
    <meta charset="utf-8">
    <title>Portál</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/styles.css">

    <!--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"
          integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA=="
          crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta3/css/bootstrap-utilities.min.css"
          integrity="sha512-aAwzwbBun7qA9M5a0LzcZKV/zJlBk0EpxsmG5c6icCDqxY64RVTHm9iG+tcwcrCWJRpkqZMHit6bOXAkOyYpFg=="
          crossorigin="anonymous"/>
     -->

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap-utilities.min.css" />

    <!--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css" integrity="sha512-YBSrHBAMjFhWHodf0RF58XB/x9lmuwBtyJv1LWDHQa1nOaWNXfG3Etc/lEXfW+qBx8ne79JnzccDs59je/ccVA==" crossorigin="anonymous" />
    -->
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css" />

    <link rel="manifest" href="favicons/site.webmanifest">
    <link rel="icon" type="image/png" href="favicons/favicon-32x32.png">
    <link rel="shortcut-icon" type="image/png" href="favicons/android-chrome-192x192.png">
    <link rel="apple-touch-icon" type="image/png" href="favicons/apple-touch-icon.png">

    <!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous"></script>
            -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"
            integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg=="
            crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
</head>

<body>

<?php require_once ("components/nav.php"); ?>
<?php require_once ("components/alert-top-bar.php"); ?>
<div class="container">
    <?php
    if (isset($_GET['page'])) {
        if (file_exists($_GET['page'] . '.php')) {
            include($_GET['page'] . '.php');
        } else {
            include("components/error404.php");
            //print "404 HIBA: Nem létező oldal";
        }
    } else {
        if (! isset($_SESSION['felhasznalo'])) {
            include("register.php");
        } else {
            include("horgasznaplo.php");
        }
    }
    ?>
    <?php if (isset($_SESSION['ok'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['ok'] ?>
        </div>
        <?php
        unset($_SESSION['ok']);
    endif; ?>
    <?php
    if (isset($_GET['logout'])) {
        unset($_SESSION['felhasznalo']);
        $_SESSION = array();
        if (isset($_COOKIE['rememberme'])) {
            setcookie('rememberme', '', time() - 3600);
            unset($_COOKIE['rememberme']);
        }
        session_destroy();
    }

    if (isset($_COOKIE['rememberme'])) {
        // sql injection
        if (!empty($dbcon)) {
            $rememberme = $dbcon->real_escape_string($_COOKIE['rememberme']);
        }
        if (isset($userTable)) {
            $sql = "SELECT * FROM {$userTable} WHERE {$userTable}.remember_token = '{$rememberme}'";
        }
        $query = $dbcon->query($sql);
        if ($query->num_rows) {
            $_SESSION['felhasznalo'] = $query->fetch_assoc();
            setcookie('rememberme', $rememberme, time() + $cookie_expires);
        } else {
            setcookie('rememberme', '', time() - 3600);
        }
    }
    ?>

</div> <!-- .container end -->
</body>
</html>