<?php

require_once ("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$post_id = filter_input(INPUT_GET, 'id');
$post_id = htmlspecialchars($post_id);
if ($post_id) {
    $sql = 'SELECT `id` FROM `posts` WHERE id = ' . $post_id . ' LIMIT 1;';
    $post = db_get_one($link, $sql);
    if ($post !== false) {
        $sql = 'INSERT IGNORE INTO `likes` (`user_id`, `post_id`) VALUES (' . $_SESSION['user_id'] . ', ' . $post['id'] . ');';
        db_insert($link, $sql);
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
