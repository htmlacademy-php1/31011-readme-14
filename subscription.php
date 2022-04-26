<?php

require_once ("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$user_id = filter_input(INPUT_GET, 'user_id');
if (empty($user_id)) {
    $user_id = $_SESSION['user_id'];
}
$user_id = htmlspecialchars($user_id);

$sql = 'SELECT * FROM `subscriptions` WHERE `user_id` = ' . $_SESSION['user_id'] . ' AND `subscribed_id` = ' . $user_id . ';';
$subscr = db_get_all($link, $sql);

if (count($subscr) === 0) {
    $sql = 'INSERT INTO `subscriptions` (`user_id`, `subscribed_id`) VALUES (' . $_SESSION['user_id'] . ', ' . $user_id . ');';
    db_insert($link, $sql);
    $sess_user_id = $_SESSION['user_id'];
    $sql = <<<SQL
        SELECT uu.login login_user, us.login login_subscribed, us.email email_subscribed
        FROM `subscriptions` s
        INNER JOIN `users` uu ON s.user_id = uu.id
        INNER JOIN `users` us ON s.subscribed_id = us.id
        WHERE s.user_id = $sess_user_id AND s.subscribed_id = $user_id;
    SQL;
    $for_send_email = db_get_one($link, $sql);

    $message = new Email();
    $message->to($for_send_email['email_subscribed']);
    $message->from("mail@readme.academy");
    $message->subject("У вас новый подписчик");
    $message->text("Здравствуйте, " . $for_send_email['login_subscribed'] . ". На вас подписался новый пользователь " . $for_send_email['login_user'] .". Вот ссылка на его профиль: http://" . $_SERVER['HTTP_HOST'] . "/profile.php?user_id=" . $sess_user_id);
} else {
    $sql = 'DELETE FROM `subscriptions` WHERE `user_id` = ' . $_SESSION['user_id'] . ' AND `subscribed_id` = ' . $user_id . ';';
    db_delete($link, $sql);
}

header("Location: " . $_SERVER['HTTP_REFERER']);
