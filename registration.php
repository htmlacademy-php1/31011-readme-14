<?php

require_once ("init.php");

$errors = [];
$data_post = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email'])) {
        $errors['email']['header'] = "E-mail";
        $errors['email']['text'] = "Не заполнено обязательное поле.";
    }
    $filter_email = "";
    $filter_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if ($filter_email !== false) {
        $sql = 'SELECT * FROM `users` WHERE `email` = "' . $_POST['email'] . '" LIMIT 1;';
        $user = db_get_one($link, $sql);
        if ($user === 0){
            $errors['email']['header'] = "E-mail";
            $errors['email']['text'] = "Такой e-mail уже зарегистрирован.";
        }
    } else {
        $errors['email']['header'] = "E-mail";
        $errors['email']['text'] = "Не верный формат e-mail.";
    }
    if (empty($_POST['login'])) {
        $errors['login']['header'] = "Логин";
        $errors['login']['text'] = "Не заполнено обязательное поле.";
    }
    if (empty($_POST['password'])) {
        $errors['password']['header'] = "Пароль";
        $errors['password']['text'] = "Не заполнено обязательное поле.";
    }
    if (empty($_POST['password-repeat'])) {
        $errors['password-repeat']['header'] = "Повтор пароля";
        $errors['password-repeat']['text'] = "Не заполнено обязательное поле.";
    }
    if ($_POST['password'] !== $_POST['password-repeat']) {
        $errors['password-repeat']['header'] = "Повтор пароля";
        $errors['password-repeat']['text'] = "Введенные пароли не совпадают.";
    }

    $new_name = "";
    $filter_url = "";
    if ($_FILES['uploadfile']['tmp_name']){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tmp_type = finfo_file($finfo, $_FILES['uploadfile']['tmp_name']);
        finfo_close($finfo);
        switch ($tmp_type){
            case 'image/jpeg': $type_file = ".jpg"; break;
            case 'image/png': $type_file = ".png"; break;
            case 'image/gif': $type_file = ".gif"; break;
            default: $type_file = false;
        }
        if ($type_file !== false) {
            $new_name = uniqid() . $type_file;
            move_uploaded_file($_FILES['uploadfile']['tmp_name'], "uploads/" . $new_name);
        } else {
            $errors['password-repeat']['header'] = "Фото";
            $errors['password-repeat']['text'] = "Не верный тип файла.";
        }
    }

    if (count($errors) === 0){
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = <<<SQL
            INSERT INTO `users` (`login`, `email`, `password`, `avatar`) 
                   VALUES ("$_POST[login]", "$filter_email", "$password", "$new_name");
        SQL;
        db_insert($link, $sql);
        header("Location: login.php");
    }

    $data_post['email'] = $_POST['email'];
    $data_post['login'] = $_POST['login'];
}

$page_content = include_template('registration.php', ['errors' => $errors, 'data_post' => $data_post]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: регистрация', 'is_auth' => $is_auth]);


print($layout_content);

?>
