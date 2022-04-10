<?php

require_once ("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$content_types = get_content_types($link);

$where_sql = "";
$ctype = filter_input(INPUT_GET, 'ctype');
if ($ctype) {
    $where_sql = "WHERE p.type_id = " . $ctype;
}

$sort_field = filter_input(INPUT_GET, 'sort_field');
if (!$sort_field) {
    $sort_field = 'popular';
}

switch ($sort_field) {
    case 'likes':
        $sort = "likes_count";
    break;
    case 'date':
        $sort = "p.date";
    break;
    case 'popular':
    default:
        $sort = "p.view";
}

$direction = filter_input(INPUT_GET, 'direction');
if (!$direction) {
    $direction = 'DESC';
} else {
    $direction = "ASC";
}

$sql = "SELECT COUNT(*) cnt FROM `posts` p " . $where_sql;
$total_posts = db_get_one($link, $sql);
$total_posts = $total_posts['cnt'];
$total_pages = ceil($total_posts / $content_on_page);

$page = filter_input(INPUT_GET, 'page');
if (empty($page) || $page < 1 || $page > $total_pages) {
    $page = 1;
}

$order_sql = "ORDER BY $sort $direction";
$limit_sql = "LIMIT " . $content_on_page .  " OFFSET " . ($page-1)*$content_on_page;

$posts = get_posts($link, $where_sql, $order_sql, $limit_sql);

$page_content = include_template('main.php', ['posts' => $posts, 'content_types' => $content_types, 'ctype' => $ctype, 'page' => $page, 'total_pages' => $total_pages, 'sort_field' => $sort_field, 'direction' => $direction]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: популярное']);

print($layout_content);
?>
