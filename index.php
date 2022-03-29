<?php

require_once ("init.php");

$is_auth = rand(0, 1);

$user_name = 'Алексей'; // укажите здесь ваше имя

$posts = [];
$content_types = [];

$sql = "SELECT * FROM `content_types`";
$content_types = db_get($link, $sql);

$add_sql = "";
$ctype = filter_input(INPUT_GET, 'ctype');
if ($ctype) {
    $add_sql = "WHERE p.type_id = " . $ctype;
}

$sql = <<<SQL
    SELECT p.id, u.login, u.email, u.avatar, c.type, p.header, p.post,
        p.author_quote, p.image_link, p.video_link, p.site_link, p.date,
        COUNT(com.post_id) comments_count, COUNT(l.post_id) likes_count
    FROM `posts` p
    INNER JOIN `users` u ON p.user_id = u.id
    INNER JOIN `content_types` c ON p.type_id = c.id
    LEFT JOIN `comments` com ON p.id = com.post_id
    LEFT JOIN `likes` l ON p.id = l.post_id
    $add_sql
    GROUP BY com.post_id, l.post_id
    ORDER BY p.view DESC
    LIMIT 6;
SQL;

$posts = db_get($link, $sql);

$page_content = include_template('main.php', ['posts' => $posts, 'content_types' => $content_types, 'ctype' => $ctype]);

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'is_auth' => $is_auth]);

print($layout_content);
?>
