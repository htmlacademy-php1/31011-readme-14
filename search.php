<?php

require_once("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$posts = [];
$search = filter_input(INPUT_GET, 'search');
$search = trim($search);
if (!empty($search)) {
    $search_hashtag = substr($search, 0, 1);
    if ($search_hashtag === "#") {
        $name_hashtag = substr($search, 1);
        $name_hashtag = mysqli_real_escape_string($link, $name_hashtag);
        $where_sql = "WHERE h.hashtag = '" . $name_hashtag . "'";
        $order_sql = "ORDER BY p.date DESC";
    } else {
        $search = mysqli_real_escape_string($link, $search);
        $where_sql = "WHERE MATCH(p.header, p.post) AGAINST('" . $search . "')";
        $order_sql = "";
    }
    $posts = get_posts($link, $where_sql, $order_sql);
}

$not_read_message = not_read_messages($link, $_SESSION['user_id']);

if (count($posts) !== 0) {
    $page_content = include_template('search.php', ['search' => $search, 'posts' => $posts]);
} else {
    $page_content = include_template('noresults.php', ['search' => $search]);
}

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: страница результатов поиска', 'search' => $search, 'not_read_message' => $not_read_message]);

print($layout_content);
