<?php

require_once ("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$post = [];
$post_comments = [];
$errors = [];
$data_comment = '';

$post_id = filter_input(INPUT_GET, 'id');
if ($post_id) {
    $sql = <<<SQL
        UPDATE `posts`
        SET posts.view = posts.view + 1
        WHERE id = $post_id;
    SQL;

    db_update ($link, $sql);

    $sql = <<<SQL
        SELECT p.id, u.id user_id, u.login, u.email, u.avatar, c.type, p.header, p.post, u.date reg_date,
            p.author_quote, p.image_link, p.video_link, p.site_link, p.view,
            COUNT(DISTINCT com.id) comments_count, COUNT(DISTINCT l.user_id) likes_count,
            COUNT(DISTINCT s.user_id) subscribed, COUNT(DISTINCT p1.id) posts, COUNT(DISTINCT ss.user_id) me_subscribed
        FROM `posts` p
        INNER JOIN `users` u ON p.user_id = u.id
        INNER JOIN `content_types` c ON p.type_id = c.id
        LEFT JOIN `comments` com ON p.id = com.post_id
        LEFT JOIN `likes` l ON p.id = l.post_id
        LEFT JOIN `subscriptions` s ON u.id = s.subscribed_id
        LEFT JOIN `posts` p1 ON p.user_id = p1.user_id
        LEFT JOIN `subscriptions` ss ON ss.user_id = $_SESSION[user_id] AND ss.subscribed_id = u.id
        WHERE p.id = $post_id
        GROUP BY p.id
        ORDER BY p.view DESC
        LIMIT 1;
    SQL;

} else {
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
}

$post = db_get_one($link, $sql);

$sql_tags = <<<SQL
        SELECT h.hashtag FROM `posts_hashtags` ph
        INNER JOIN `hashtags` h ON h.id = ph.hashtag_id
        WHERE ph.post_id = $post[id];
    SQL;

$post_tags = db_get_all($link, $sql_tags);

$sql_comments = <<<SQL
    SELECT u.id user_id, u.login, u.avatar, c.post, c.date 
    FROM `comments` c
    LEFT JOIN `users` u ON u.id = c.user_id
    WHERE c.post_id = $post[id]
    ORDER BY c.date DESC;
SQL;

$post_comments = db_get_all($link, $sql_comments);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST['post_id'] = htmlspecialchars($_POST['post_id']);

    if (empty($_POST['comment'])) {
        $errors['comment']['header'] = "Комментарий";
        $errors['comment']['text'] = "Не заполнено обязательное поле.";
    } else {
        $_POST['comment'] = trim($_POST['comment']);
        $lenght_comment = strlen($_POST['comment']);
        if ($lenght_comment >= 4) {
            $_POST['comment'] = htmlspecialchars($_POST['comment']);
        } else {
            $errors['comment']['header'] = "Комментарий";
            $errors['comment']['text'] = "Слишком короткий комментарий.";
        }
    }
    $data_comment = $_POST['comment'];

    if (count($errors) === 0) {
        $sql = 'SELECT p.user_id FROM `posts` p WHERE p.id = ' . $_POST['post_id'] . ' LIMIT 1;';
        $post_comment = db_get_one($link, $sql);
        if ($post_comment !== false) {
            $sql = 'INSERT INTO `comments` (`user_id`, `post_id`, `post`) VALUES (' . $_SESSION['user_id'] . ', ' . $_POST['post_id'] . ', "' . $_POST['comment'] . '")';
            db_insert($link, $sql);
            header("Location: profile.php?user_id=" . $post_comment['user_id']);
        }
    }
}

$page_content = include_template('post_' . $post['type'] . '.php', ['post' => $post]);
$page_content = include_template('post.php', ['content' => $page_content,'post' => $post, 'tags' => $post_tags, 'post_comments' => $post_comments, 'errors' => $errors, 'data_comment' => $data_comment]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: публикация']);


print($layout_content);

?>
