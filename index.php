<?php
date_default_timezone_set('Asia/Tomsk');

require_once 'helpers.php';
$is_auth = rand(0, 1);

$user_name = 'Алексей'; // укажите здесь ваше имя

$posts = [
    ['header' => 'Цитата', 'type' => 'post-quote', 'post' => 'Мы в жизни любим только раз, а после ищем лишь похожих', 'name_user' => 'Лариса', 'avatar' => 'userpic-larisa-small.jpg'],
    ['header' => 'Игра престолов', 'type' => 'post-text', 'post' => 'Не могу дождаться начала финального сезона своего любимого сериала! В массиве с постами для текстового поста укажите в содержимом очень длинный текст. Проверьте, что этот текст корректно обрезается с добавлением ссылки. Затем проверьте короткий текст, который должен отображаться без изменений. В массиве с постами для текстового поста укажите в содержимом очень длинный текст. Проверьте, что этот текст корректно обрезается с добавлением ссылки. Затем проверьте короткий текст, который должен отображаться без изменений.', 'name_user' => 'Владик', 'avatar' => 'userpic.jpg'],
    ['header' => 'Наконец, обработал фотки!', 'type' => 'post-photo', 'post' => 'rock-medium.jpg', 'name_user' => 'Виктор', 'avatar' => 'userpic-mark.jpg'],
    ['header' => 'Моя мечта', 'type' => 'post-photo', 'post' => 'coast-medium.jpg', 'name_user' => 'Лариса', 'avatar' => 'userpic-larisa-small.jpg'],
    ['header' => 'Лучшие курсы', 'type' => 'post-link', 'post' => 'www.htmlacademy.ru', 'name_user' => 'Владик', 'avatar' => 'userpic.jpg']
];

// Заполнение врЕменного массива данных временнЫми метками
foreach ($posts as $key => $post) {
    $posts[$key]['post_date'] = generate_random_date($key);
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
    $month = $week / 30;

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


$page_content = include_template('main.php', ['posts' => $posts]);

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'is_auth' => $is_auth]);

print($layout_content);
?>
