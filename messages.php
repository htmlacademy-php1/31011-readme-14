<?php

require_once("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}

$errors = [];
$contacts = [];
$sess_id = mysqli_real_escape_string($link, $_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST['message'] = htmlspecialchars($_POST['message']);
    $_POST['message'] = trim($_POST['message']);

    if (empty($_POST['message'])) {
        $errors['message']['header'] = "Сообщение";
        $errors['message']['text'] = "Не заполнено обязательное поле.";
    }

    $_POST['user_id'] = mysqli_real_escape_string($link, $_POST['user_id']);
    $_POST['message'] = mysqli_real_escape_string($link, $_POST['message']);

    $sql = "SELECT `id` FROM `users` WHERE id = " . $_POST['user_id'] . ";";
    $message_recipient = db_get_one($link, $sql);

    if (($message_recipient !== false) and ($_POST['user_id'] !== $sess_id) and (count($errors) === 0)) {
        $sql = "INSERT INTO `messages` (`sender_id`, `recipient_id`, `message`) VALUES (" . $sess_id . ", " . $_POST['user_id'] . ", '" . $_POST['message'] . "');";
        db_insert($link, $sql);
        header("Location: messages.php?user_id=" . $_POST['user_id']);
    }
}

$sql = <<<SQL
    SELECT u.id, u.login, u.avatar,
        (SELECT m.message
         FROM messages m
         WHERE u.id = m.sender_id OR u.id = m.recipient_id
         ORDER BY m.date DESC
         LIMIT 1) AS message,

        (SELECT m.date
         FROM messages m
         WHERE u.id = m.sender_id OR u.id = m.recipient_id
         ORDER BY m.date DESC
         LIMIT 1) AS message_date,

        (SELECT COUNT(*)
         FROM messages m
         WHERE m.recipient_id = $sess_id AND m.sender_id = u.id AND m.is_read = 0
         ) AS not_read
    FROM users u
    LEFT JOIN messages m ON u.id = m.recipient_id OR u.id = m.sender_id
    WHERE (m.recipient_id = $sess_id AND m.recipient_id != u.id) OR (m.sender_id = $sess_id AND m.sender_id != u.id)
    GROUP BY u.id
    ORDER BY message_date DESC;
SQL;
$contacts = db_get_all($link, $sql);

$user_id = filter_input(INPUT_GET, 'user_id');
if (empty($user_id)) {
    $user_id = $contacts[0]['id'];
}
$user_id = htmlspecialchars($user_id);
$user_id = mysqli_real_escape_string($link, $user_id);

$sql = <<<SQL
    UPDATE messages
    SET is_read = 1
    WHERE sender_id = $user_id AND recipient_id = $sess_id;
SQL;
db_update($link, $sql);

$sql = <<<SQL
    SELECT u.id, m.message, m.date, u.login, u.avatar
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE (sender_id = $user_id AND recipient_id = $sess_id) OR (recipient_id = $user_id AND sender_id = $sess_id)
    ORDER BY m.date ASC;
SQL;
$messages = db_get_all($link, $sql);

$not_read_message = not_read_messages($link, $_SESSION['user_id']);

$page_content = include_template('messages.php', ['errors' => $errors, 'contacts' => $contacts, 'user_id' => $user_id, 'messages' => $messages]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: личные сообщения', 'not_read_message' => $not_read_message]);

print($layout_content);
