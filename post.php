<?php
date_default_timezone_set('Asia/Tomsk');

require_once 'helpers.php';
$db = require_once("db.php");


$post = [];

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

if (!$link) {
    $error = mysqli_connect_error();
    die ($error);
}

if ($post_id = filter_input(INPUT_GET, 'id')) {
    $sql = <<<SQL
        UPDATE `posts`
        SET posts.view = posts.view + 1
        WHERE id = $post_id;
    SQL;

    if (!$result = mysqli_query($link, $sql)) {
        $error = mysqli_error();
        print($error);
    }

    $sql = <<<SQL
        SELECT p.id, u.login, u.email, u.avatar, c.type, p.header, p.post,
            p.author_quote, p.image_link, p.video_link, p.site_link, p.date, p.view,
            COUNT(com.post_id) comments_count, COUNT(l.post_id) likes_count,
            COUNT(s.subscribed_id) subscribed, COUNT(p1.user_id) posts
        FROM `posts` p
        INNER JOIN `users` u ON p.user_id = u.id
        INNER JOIN `content_types` c ON p.type_id = c.id
        LEFT JOIN `comments` com ON p.id = com.post_id
        LEFT JOIN `likes` l ON p.id = l.post_id
        LEFT JOIN `subscriptions` s ON p.user_id = s.user_id
        LEFT JOIN `posts` p1 ON p.user_id = p1.user_id
        WHERE p.id = $post_id
        GROUP BY com.post_id, l.post_id, s.subscribed_id, p1.user_id
        ORDER BY p.view DESC
        LIMIT 1;
    SQL;

} else {
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
}

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    }
} else {
    $error = mysqli_error();
    print($error);
}




$page_content = include_template('post_' . $post[0]['type'] . '.php', ['post' => $post[0]]);

$layout_content = include_template('post.php', ['content' => $page_content, 'title' => 'readme: популярное', 'post' => $post[0]]);

print($layout_content);

?>
