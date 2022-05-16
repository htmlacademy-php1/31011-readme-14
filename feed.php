<?php

require_once("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$content_types = get_content_types($link);

$where_sql = "";
$ctype = filter_input(INPUT_GET, 'ctype');
if ($ctype) {
    $ctype = mysqli_real_escape_string($link, $ctype);
    $where_sql = "WHERE p.type_id = " . $ctype;
}

$order_sql = 'ORDER BY p.date DESC';
$posts = get_posts_by_subscribed($link, $where_sql, $order_sql, $_SESSION['user_id']);

$not_read_message = not_read_messages($link, $_SESSION['user_id']);

$page_content = include_template('feed.php', ['content_types' => $content_types, 'ctype' => $ctype, 'posts' => $posts]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: моя лента', 'not_read_message' => $not_read_message]);

print($layout_content);
