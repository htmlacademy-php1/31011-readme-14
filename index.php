<?php
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

$page_content = include_template('main.php', ['posts' => $posts]);

$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: популярное', 'is_auth' => $is_auth]);

print($layout_content);
?>

