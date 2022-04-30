<?php

require_once("init.php");

if (empty($_SESSION)) {
    header("Location: index.php");
}



$page_content = include_template('messages.php', []);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: личные сообщения']);

print($layout_content);
