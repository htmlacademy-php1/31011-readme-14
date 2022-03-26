<?php
date_default_timezone_set('Asia/Tomsk');

require_once 'helpers.php';
$db = require_once("db.php");

$is_auth = rand(0, 1);

$user_name = 'Алексей'; // укажите здесь ваше имя

$posts = [];
$content_types = [];

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

if (!$link) {
    $error = mysqli_connect_error();
    die ($error);
} 

$sql = "SELECT * FROM `content_types`";

if ($result = mysqli_query($link, $sql)) {
    $content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error();
    print($error);
}

$sql = <<<SQL
SELECT p.id, u.login, u.email, u.avatar, c.type, p.header, p.post, p.author_quote, p.image_link, p.video_link, p.site_link, p.date, COUNT(com.post_id) comments_count, COUNT(l.post_id) likes_count FROM `posts` p
INNER JOIN `users` u ON p.user_id = u.id
INNER JOIN `content_types` c ON p.type_id = c.id
LEFT JOIN `comments` com ON p.id = com.post_id
LEFT JOIN `likes` l ON p.id = l.post_id
GROUP BY com.post_id, l.post_id
ORDER BY p.view DESC
LIMIT 6;
SQL;

if ($result = mysqli_query($link, $sql)) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error();
    print($error);
}

// Функция для обрезки пользовательских постов с добавлением ссылки на полный текст поста
function cropping_post ($post, $lenght=300) {
    if (strlen($post) >= $lenght) {
        $words_post = explode(" ", $post);
        $lenght_post = 0;
        for ($i=0; $i<count($words_post); $i++) {
            $lenght_post += strlen($words_post[$i]);
            if ($lenght_post > $lenght) {
                break;
            }
        }
        $words_post = array_slice($words_post, 0, $i-1);
        $post = implode(" ", $words_post);
        $post = "<p>" . $post . "...</p>";
        $post .= '<a class="post-text__more-link" href="#">Читать далее</a>'; 
    } else {
        $post = "<p>" . $post . "</p>";
    }
    return $post;
}

// Функция для перевода времени поста в относительный формат
function convert_date_relative_format($date) {
    $sec = time() - strtotime($date);
    $min = $sec / 60;
    $hour = $min / 60;
    $day = $hour / 24;
    $week = $day / 7;
    $month = $week / 4;

    if ($min < 60) {
        $date = floor($min);
        $date .= " " . get_noun_plural_form($date, "минута", "минуты", "минут");
    } elseif ($min >= 60 && $hour < 24) {
        $date = floor($hour);
        $date .= " " . get_noun_plural_form($date, "час", "часа", "часов");
    } elseif ($hour >= 24 && $day < 7) {
        $date = floor($day);
        $date .= " " . get_noun_plural_form($date, "день", "дня", "дней");
    } elseif ($day >= 7 && $week < 5) {
        $date = floor($week);
        $date .= " " . get_noun_plural_form($date, "неделя", "недели", "недель");
    } elseif ($week >= 5) {
        $date = floor($month);
        $date .= " " . get_noun_plural_form($date, "месяц", "месяца", "месяцев");
    }
    
    return $date . " назад";
}


$page_content = include_template('main.php', ['posts' => $posts, 'content_types' => $content_types]);

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'is_auth' => $is_auth]);

print($layout_content);
?>
