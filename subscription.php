<?php

require_once ("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$user_id = filter_input(INPUT_GET, 'user_id');
if (empty($user_id)) {
    $user_id = $_SESSION['user_id'];
}
$user_id = htmlspecialchars($user_id);

$sql = 'SELECT * FROM `subscriptions` WHERE `user_id` = ' . $_SESSION['user_id'] . ' AND `subscribed_id` = ' . $user_id . ';';
$subscr = db_get_all($link, $sql);

if (count($subscr) === 0) {
    $sql = 'INSERT INTO `subscriptions` (`user_id`, `subscribed_id`) VALUES (' . $_SESSION['user_id'] . ', ' . $user_id . ');';
    db_insert($link, $sql);
} else {
    $sql = 'DELETE FROM `subscriptions` WHERE `user_id` = ' . $_SESSION['user_id'] . ' AND `subscribed_id` = ' . $user_id . ';';
    db_delete($link, $sql);
}

header("Location: " . $_SERVER['HTTP_REFERER']);
?>
