<?php

require_once ("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$posts = [];

$content_types = get_content_types($link);

$add_sql = "";
$ctype = filter_input(INPUT_GET, 'ctype');
if ($ctype) {
    $add_sql = " AND p.type_id = " . $ctype;
}

$sql = <<<SQL
    SELECT p.id, u.id user_id, u.login, u.email, u.avatar, c.type, p.header, p.post,
           p.author_quote, p.image_link, p.video_link, p.site_link, p.date,
           COUNT(DISTINCT com.post_id) comments_count, COUNT(DISTINCT l.post_id) likes_count
    FROM `posts` p
    INNER JOIN `users` u ON p.user_id = u.id
    INNER JOIN `content_types` c ON p.type_id = c.id
    LEFT JOIN `comments` com ON p.id = com.post_id
    LEFT JOIN `likes` l ON p.id = l.post_id
    WHERE p.user_id IN (SELECT s.subscribed_id FROM `subscriptions` s WHERE s.user_id = $_SESSION[user_id]) $add_sql
    GROUP BY p.id
    ORDER BY p.date DESC;
SQL;

$posts = db_get_all($link, $sql);

if (count($posts) !== 0) {
    $page_content = include_template('feed.php', ['content_types' => $content_types, 'ctype' => $ctype, 'posts' => $posts]);
} else {
    $page_content = include_template('nocontent.php', ['content_types' => $content_types, 'ctype' => $ctype]);
}
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: моя лента']);

print($layout_content);
?>
