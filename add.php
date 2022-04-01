<?php

require_once ("init.php");

$is_auth = rand(0, 1);



$sql = "SELECT * FROM `content_types`";
$content_types = db_get_all($link, $sql);

$ctype = filter_input(INPUT_GET, 'ctype');
if (!$ctype) {
    $ctype = 1;
}

$errors = [];
$data_post = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($_POST as $key => $value){
        $$key = htmlspecialchars($value);
    }

    if (empty($header)) {
        $errors['header']['header'] = "Заголовок";
        $errors['header']['text'] = "Не заполнено обязательное поле.";
    }
    $data_post['header'] = $header;
    $data_post['tags'] = $tags;

    switch ($ctype) {   
        case 1: {
            if (empty($post)) {
                $errors['post']['header'] = "Текст поста";
                $errors['post']['text'] = "Не заполнено обязательное поле.";
            }
            $data_post['post'] = $post;
            $sql = <<<SQL
                INSERT INTO `posts` (`user_id`, `type_id`, `header`, `post`, `author_quote`, `image_link`, `video_link`, `site_link`)
                       VALUES       (1, $ctype, "$header", "$post", NULL, NULL, NULL, NULL);
            SQL;
        }; break;
        case 2: {
            if (empty($post)) {
                $errors['post']['header'] = "Текст цитаты";
                $errors['post']['text'] = "Не заполнено обязательное поле.";
            }
            if (empty($author_quote)) {
                $errors['author_quote']['header'] = "Автор цитаты";
                $errors['author_quote']['text'] = "Не заполнено обязательное поле.";
            }
            $data_post['post'] = $post;
            $data_post['author_quote'] = $author_quote;
            $sql = <<<SQL
                INSERT INTO `posts` (`user_id`, `type_id`, `header`, `post`, `author_quote`, `image_link`, `video_link`, `site_link`)
                       VALUES       (1, $ctype, "$header", "$post", "$author_quote", NULL, NULL, NULL);
            SQL;
        }; break;
        case 3: {
            $new_name = "";
            $filter_url = "";
            if ($_FILES['uploadfile']['tmp_name']){
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $tmp_type = finfo_file($finfo, "uploads/" . $tmp_name);
                finfo_close($finfo);
                switch ($tmp_type){
                    case 'image/jpeg': $type_file = ".jpg"; break;
                    case 'image/png': $type_file = ".png"; break;
                    case 'image/gif': $type_file = ".gif"; break;
                }
                $new_name = uniqid() . $type_file;
                move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $new_name);
        
            } elseif ($photo_link) {
                $filter_url = filter_var($photo_link, FILTER_VALIDATE_URL);
                if ($filter_url != false) {
                    $file = file_get_contents($filter_url);
                    if ($file != false) {
                        $tmp_name = "tmp_" . uniqid();
                        file_put_contents("uploads/" . $tmp_name, $file);
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $tmp_type = finfo_file($finfo, "uploads/" . $tmp_name);
                        finfo_close($finfo);
                        switch ($tmp_type){
                            case 'image/jpeg': $type_file = ".jpg"; break;
                            case 'image/png': $type_file = ".png"; break;
                            case 'image/gif': $type_file = ".gif"; break;
                            default: $type_file = false;
                        }
                        if ($type_file != false) {
                            $new_name = uniqid() . $type_file;
                            rename("uploads/" . $tmp_name, "uploads/" . $new_name);
                        } else {
                            unlink ("uploads/" . $tmp_name);
                            $errors['photo']['header'] = "Ссылка на фото";
                            $errors['photo']['text'] = "Не верный тип файла по ссылке";
                        }
                    } else {
                        $errors['photo']['header'] = "Ссылка на фото";
                        $errors['photo']['text'] = "Не удалось закачать фото";
                    }
                } else {
                    $errors['photo']['header'] = "Ссылка на фото";
                    $errors['photo']['text'] = "Неверный формат ссылки";
                }
            } else {
                $errors['photo']['header'] = "Фото";
                $errors['photo']['text'] = "Не выбран файл";
            }
            $data_post['filter_url'] = $filter_url;
            $sql = <<<SQL
                INSERT INTO `posts` (`user_id`, `type_id`, `header`, `post`, `author_quote`, `image_link`, `video_link`, `site_link`)
                       VALUES       (1, $ctype, "$header", "$new_name", NULL, "$new_name", NULL, NULL);
            SQL;
        }; break;
        case 4: {
            $filter_url = "";
            if (!empty($video_link)) {
                $filter_url = filter_var($video_link, FILTER_VALIDATE_URL);
                if ($filter_url != false) {
                    $check = check_youtube_url($filter_url);
                    if ($check !== true) {
                        $errors['video_link']['header'] = "Ссылка на YOUTUBE";
                        $errors['video_link']['text'] = $check;
                    }
                } else {
                    $errors['video_link']['header'] = "Ссылка на YOUTUBE";
                    $errors['video_link']['text'] = "Неверный формат ссылки";
                }
            } else {
                $errors['video_link']['header'] = "Ссылка YOUTUBE";
                $errors['video_link']['text'] = "Не заполнено обязательное поле.";
            }
            $data_post['filter_url'] = $filter_url;
            $sql = <<<SQL
                INSERT INTO `posts` (`user_id`, `type_id`, `header`, `post`, `author_quote`, `image_link`, `video_link`, `site_link`)
                       VALUES       (1, $ctype, "$header", "$filter_url", NULL, NULL, "$filter_url", NULL);
            SQL;
        }; break;
        case 5: {
            $filter_url = "";
            if (!empty($site_link)) {
                $filter_url = filter_var($site_link, FILTER_VALIDATE_URL);
                if ($filter_url === false) {
                    $errors['site_link']['header'] = "Ссылка";
                    $errors['site_link']['text'] = "Неверный формат ссылки";
                }
            } else {
                $errors['site_link']['header'] = "Ссылка";
                $errors['site_link']['text'] = "Не заполнено обязательное поле.";
            }
            $data_post['filter_url'] = $filter_url;
            $sql = <<<SQL
                INSERT INTO `posts` (`user_id`, `type_id`, `header`, `post`, `author_quote`, `image_link`, `video_link`, `site_link`)
                       VALUES       (1, $ctype, "$header", "$filter_url", NULL, NULL, NULL, "$filter_url");
            SQL;
        }; break;
        default: {
            $errors['ctype']['header'] = "Категория публикации";
            $errors['ctype']['text'] = "Выбрана не существующая категория.";
        }
    }

    if (count($errors) === 0) {
        $post_id = db_insert($link, $sql);
        $post_tags = [];
        if ($tags) {
            $post_tags = explode(" ", $tags);
            if (count($post_tags) > 0) {
                foreach ($post_tags as $value) {
                    $value = htmlspecialchars($value);
                    $sql = 'SELECT `id` FROM `hashtags` WHERE `hashtag` = "' . $value . '" LIMIT 1;';
                    $tag_id = db_get_one($link, $sql);
    
                    if ($tag_id === false) {
                        $sql = <<<SQL
                            INSERT INTO `hashtags` (`hashtag`) 
                                   VALUES ("$value");
                        SQL;
                        $tag_id = db_insert($link, $sql);
                    } else {
                        $tag_id = $tag_id['id'];
                    }
                    
                    $sql = <<<SQL
                        INSERT INTO `posts_hashtags` (`post_id`, `hashtag_id`) 
                               VALUES ($post_id, $tag_id);
                    SQL;
                    db_insert($link, $sql);
                }
            }
        }
        header("Location: post.php?id=" . $post_id);
    }

    
    
     

    

    

    

    print_r("<pre>");
    print_r($_POST);
    print_r("</pre>");
    
    print_r("<pre>");
    print_r($errors);
    print_r("</pre>");


    print_r("<pre>");
    print_r($data_post);
    print_r("</pre>");
#    die;



}

$page_content = include_template('add.php', ['content_types' => $content_types, 'ctype' => (int)$ctype, 'errors' => $errors, 'data_post' => $data_post]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'readme: добавление публикации', 'is_auth' => $is_auth]);


print($layout_content);

?>
