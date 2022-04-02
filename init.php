<?php
date_default_timezone_set('Asia/Tomsk');

require_once ("helpers.php");
$db = require_once("db.php");
require_once("db_helpers.php");

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

if (!$link) {
    $error = mysqli_connect_error();
    die ($error);
}

$is_auth = rand(0, 1);
$user_name = 'Алексей'; // укажите здесь ваше имя


?>
