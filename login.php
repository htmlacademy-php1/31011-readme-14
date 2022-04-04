<?php

require_once ("init.php");

$errors = [];
$data_post = [];

$page_content = include_template('login.php', ['errors' => $errors, 'data_post' => $data_post]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: авторизация', 'is_auth' => $is_auth]);


print($layout_content);

?>
