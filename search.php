<?php

require_once ("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$posts = [];
$search = filter_input(INPUT_GET, 'search');
$search = trim($search);
if (!empty($search)) {
    $search_hashtag = substr($search, 0, 1);
    if ($search_hashtag == "#") {
        $name_hashtag = substr($search, 1);
        
        $sql = <<<SQL
            SELECT p.id, u.login, u.email, u.avatar, c.type, p.header, p.post,
                p.author_quote, p.image_link, p.video_link, p.site_link, p.date,
                COUNT(com.post_id) comments_count, COUNT(l.post_id) likes_count
            FROM `posts` p
            INNER JOIN `users` u ON p.user_id = u.id
            INNER JOIN `content_types` c ON p.type_id = c.id
            LEFT JOIN `comments` com ON p.id = com.post_id
            LEFT JOIN `likes` l ON p.id = l.post_id
            LEFT JOIN `posts_hashtags` ph ON p.id = ph.post_id
            LEFT JOIN `hashtags` h ON ph.hashtag_id = h.id
            WHERE h.hashtag = "$name_hashtag"
            GROUP BY com.post_id, l.post_id
            ORDER BY p.date DESC;
        SQL;
    } else {
        $sql = <<<SQL
            SELECT p.id, u.login, u.email, u.avatar, c.type, p.header, p.post,
                p.author_quote, p.image_link, p.video_link, p.site_link, p.date,
                COUNT(com.post_id) comments_count, COUNT(l.post_id) likes_count
            FROM `posts` p
            INNER JOIN `users` u ON p.user_id = u.id
            INNER JOIN `content_types` c ON p.type_id = c.id
            LEFT JOIN `comments` com ON p.id = com.post_id
            LEFT JOIN `likes` l ON p.id = l.post_id
            WHERE MATCH(p.header, p.post) AGAINST("$search")
            GROUP BY com.post_id, l.post_id;
        SQL;
    }

    $posts = db_get_all($link, $sql);

}



if (count($posts) !== 0) {
    $page_content = include_template('search.php', ['search' => $search, 'posts' => $posts]);
} else {
    $page_content = include_template('noresults.php', ['search' => $search]);
}

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: страница результатов поиска', 'search' => $search]);

print($layout_content);
?>
