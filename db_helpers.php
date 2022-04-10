<?php

function db_get_all ($link, $sql) {
    $result = mysqli_query($link, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error();
        print($error);
    }
}

function db_get_one ($link, $sql) {
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if ($array) {
            return $array[0];
        } else {
            return false;
        }
    } else {
        $error = mysqli_error();
        print($error);
    }
}

function db_update ($link, $sql) {
    $result = mysqli_query($link, $sql);
    if (!$result) {
        $error = mysqli_error();
        print($error);
    }
}

function db_insert ($link, $sql) {
    $result = mysqli_query($link, $sql);
    if (!$result) {
        $error = mysqli_error();
        print($error);
    } else {
        return mysqli_insert_id($link);
    }
}

function db_delete ($link, $sql) {
    $result = mysqli_query($link, $sql);
    if (!$result) {
        $error = mysqli_error();
        print($error);
    }
}

function get_content_types($link) {
    $sql = "SELECT * FROM `content_types`";
    $content_types = db_get_all($link, $sql);
    if ($content_types) {
        return $content_types;
    } else {
        return [];
    }
}

function get_posts($link, $where, $order, $limit = '') {
    $user_id = $_SESSION['user_id'];
    $sql = <<<SQL
        SELECT p.id, u.id user_id, u.login, u.email, u.avatar, c.type, p.header, p.post, p.date, u.date reg_date,
            p.author_quote, p.image_link, p.video_link, p.site_link, p.view,
            COUNT(DISTINCT com.id) comments_count, COUNT(DISTINCT l.user_id) likes_count,
            COUNT(DISTINCT s.user_id) subscribed, COUNT(DISTINCT p1.id) posts, COUNT(DISTINCT s1.user_id) me_subscribed
        FROM `posts` p
        INNER JOIN `users` u ON p.user_id = u.id
        INNER JOIN `content_types` c ON p.type_id = c.id
        LEFT JOIN `comments` com ON p.id = com.post_id
        LEFT JOIN `likes` l ON p.id = l.post_id
        LEFT JOIN `subscriptions` s ON u.id = s.subscribed_id
        LEFT JOIN `posts` p1 ON p.user_id = p1.user_id
        LEFT JOIN `subscriptions` s1 ON s1.user_id = $user_id AND s1.subscribed_id = u.id
        LEFT JOIN `posts_hashtags` ph ON p.id = ph.post_id
        LEFT JOIN `hashtags` h ON ph.hashtag_id = h.id
        $where
        GROUP BY p.id
        $order
        $limit;
    SQL;
    $posts = db_get_all($link, $sql);
    if (!$posts) {
        return [];
    } elseif (count($posts) === 1) {
        return $posts[0];
    } else {
        return $posts;
    }
}
?>
