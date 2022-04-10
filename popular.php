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
    $add_sql = "WHERE p.type_id = " . $ctype;
}

$sort_field = filter_input(INPUT_GET, 'sort_field');
if (!$sort_field) {
    $sort_field = 'popular';
}

switch ($sort_field) {
    case 'likes':
        $sort_sql = "likes_count";
    break;
    case 'date':
        $sort_sql = "p.date";
    break;
    case 'popular':
    default:
        $sort_sql = "p.view";
}

$direction = filter_input(INPUT_GET, 'direction');
if (!$direction) {
    $direction = 'DESC';
} else {
    $direction = "ASC";
}

$sql = "SELECT `id` FROM `posts` p " . $add_sql;
$posts_all = db_get_all($link, $sql);
$total_posts = count($posts_all);
$total_pages = ceil($total_posts / $content_on_page);

$page = filter_input(INPUT_GET, 'page');
if (empty($page) or $page < 1 or $page > $total_pages) {
    $page = 1;
}

$limit_sql = "LIMIT " . $content_on_page .  " OFFSET " . ($page-1)*$content_on_page;


$sql = <<<SQL
    SELECT p.id, u.id user_id, u.login, u.email, u.avatar, c.type, p.header, p.post,
        p.author_quote, p.image_link, p.video_link, p.site_link, p.date,
        COUNT(DISTINCT com.id) comments_count, COUNT(DISTINCT l.user_id) likes_count
    FROM `posts` p
    INNER JOIN `users` u ON p.user_id = u.id
    INNER JOIN `content_types` c ON p.type_id = c.id
    LEFT JOIN `comments` com ON p.id = com.post_id
    LEFT JOIN `likes` l ON p.id = l.post_id
    $add_sql
    GROUP BY p.id
    ORDER BY $sort_sql $direction
    $limit_sql;
SQL;

$posts = db_get_all($link, $sql);

$page_content = include_template('main.php', ['posts' => $posts, 'content_types' => $content_types, 'ctype' => $ctype, 'page' => $page, 'total_pages' => $total_pages, 'sort_field' => $sort_field, 'direction' => $direction]);

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: популярное']);

print($layout_content);
?>
