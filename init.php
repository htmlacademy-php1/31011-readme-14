<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require_once ("vendor/autoload.php");
require_once("mailconfig.php"); # тут расположена переменная $dsn
require_once ("helpers.php");
$db = require_once("db.php");
require_once("db_helpers.php");

$transport = Transport::fromDsn($dsn);

session_start();

date_default_timezone_set('Asia/Tomsk');

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

if (!$link) {
    $error = mysqli_connect_error();
    die ($error);
}

$content_on_page = 6;
