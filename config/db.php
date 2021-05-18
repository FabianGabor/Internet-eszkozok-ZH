<?php
/*
 * CREATE TABLE `bejelentesek`.`jelentesek` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `elotag` VARCHAR(8) NULL ,
 * `vezeteknev` VARCHAR(255) NOT NULL , `keresztnev` VARCHAR(255) NOT NULL , `allandoLakcim` VARCHAR(255) NOT NULL ,
 * `ertesitesiCim` VARCHAR(255) NULL , `szuletesiIdo` DATE NOT NULL , `szuletesiHely` VARCHAR(128) NULL ,
 * `anyjaNeve` VARCHAR(128) NULL , `telefon` VARCHAR(13) NOT NULL , `email` VARCHAR(128) NOT NULL ,
 * `jelszo` VARCHAR(128) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
 */

$host = 'localhost';
$db = 'internet_eszkozok_zh';
$user = 'internet_eszkozok_zh';
$password = 'internet_eszkozok_zh';

$salt = "nNUGIBREDnnvujW8324";
$userTable = 'felhasznalok';
$galleriesTable = 'galeriak';
$cookie_expires = 5 * 1;


//define('GALLERY_PATH', '/home/gabor/Documents/Coding/Internet-eszkozok/internet_eszkozok_zh/media/img/');
define('GALLERY_PATH', dirname(__DIR__).'/media/');

$dbcon = new mysqli($host, $user, $password, $db);

if ($dbcon->connect_error) {
    die ('Sikertelen adatbázis kapcsolódás') . $dbcon->connect_error;
}

session_start(); // S_SESSION, $_COOKIE, setcookie(name, [content], [time]);

if (isset($_SESSION['felhasznalo'])) {
    define("AUTH", true);
} else {
    define("AUTH", false);
}