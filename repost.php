<?php

require_once("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$post_id = filter_input(INPUT_GET, 'id');
$post_id = htmlspecialchars($post_id);
$sess_user_id = mysqli_real_escape_string($link, $_SESSION['user_id']);
if ($post_id) {
    $post_id = mysqli_real_escape_string($link, $post_id);
    $sql = <<<SQL
        INSERT INTO `posts` (`user_id`, `type_id`, `header`, `post`, `author_quote`, `image_link`,
                             `video_link`, `site_link`, `repost`, `post_id_original`)
        SELECT $sess_user_id, `type_id`, `header`, `post`, `author_quote`, `image_link`,
                             `video_link`, `site_link`, 1, `id`
        FROM `posts`
        WHERE `id` = $post_id;
    SQL;
    $post = db_insert($link, $sql);
}

header('Location: profile.php');
