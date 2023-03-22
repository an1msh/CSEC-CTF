<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'ctf_user');
define('DB_PASSWORD', 'reconftw');
define('DB_NAME', 'ctf_db');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>
