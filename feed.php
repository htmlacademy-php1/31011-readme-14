<?php

require_once ("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$content_types = get_content_types($link);

$add_sql = "";
$ctype = filter_input(INPUT_GET, 'ctype');
if ($ctype) {
    $add_sql = " AND p.type_id = " . $ctype;
}

$where_sql = "WHERE p.user_id IN (SELECT s.subscribed_id FROM `subscriptions` s WHERE s.user_id = " . $_SESSION['user_id'] . ") " . $add_sql;
$order_sql = 'ORDER BY p.date DESC';
$posts = get_posts($link, $where_sql, $order_sql);

$page_content = include_template('feed.php', ['content_types' => $content_types, 'ctype' => $ctype, 'posts' => $posts]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: моя лента']);

print($layout_content);
?>
