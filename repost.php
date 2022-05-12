<?php

require_once("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$post_id = filter_input(INPUT_GET, 'id');
$post_id = htmlspecialchars($post_id);
$post_id = mysqli_real_escape_string($link, $post_id);
$sql = "SELECT `id` FROM `posts` WHERE `id` = " . $post_id . ";";
$post = db_get_all($link, $sql);

if ($post) {
    $sess_user_id = mysqli_real_escape_string($link, $_SESSION['user_id']);
    $sql = <<<SQL
        INSERT INTO `posts` (`user_id`, `type_id`, `header`, `post`, `author_quote`, `image_link`,
                            `video_link`, `site_link`, `repost_id`)
        SELECT $sess_user_id, `type_id`, `header`, `post`, `author_quote`, `image_link`,
                            `video_link`, `site_link`, `id`
        FROM `posts`
        WHERE `id` = $post_id;
    SQL;
    db_insert($link, $sql);
}

header('Location: profile.php');
