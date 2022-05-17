<?php

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else {
                if (is_string($value)) {
                    $type = 's';
                } else {
                    if (is_double($value)) {
                        $type = 'd';
                    }
                }
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Функция проверяет доступно ли видео по ссылке на youtube
 * @param string $url ссылка на видео
 *
 * @return string Ошибку если валидация не прошла
 */
function check_youtube_url($url)
{
    $id = extract_youtube_id($url);

    set_error_handler(function () {}, E_WARNING);
    $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $id);
    restore_error_handler();

    if (!is_array($headers)) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    $err_flag = strpos($headers[0], '200') ? 200 : 404;

    if ($err_flag !== 200) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    return true;
}

/**
 * Возвращает код iframe для вставки youtube видео на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_video($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = "https://www.youtube.com/embed/" . $id;
        $res = '<iframe width="760" height="400" src="' . $src . '" frameborder="0"></iframe>';
    }

    return $res;
}

/**
 * Возвращает img-тег с обложкой видео для вставки на страницу
 * @param string|null $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_cover(string $youtube_url = null)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = sprintf("https://img.youtube.com/vi/%s/mqdefault.jpg", $id);
        $res = '<img alt="youtube cover" width="320" height="120" src="' . $src . '" />';
    }

    return $res;
}

/**
 * Извлекает из ссылки на youtube видео его уникальный ID
 * @param string $youtube_url Ссылка на youtube видео
 * @return array
 */
function extract_youtube_id($youtube_url)
{
    $id = false;

    $parts = parse_url($youtube_url);

    if ($parts) {
        if ($parts['path'] == '/watch') {
            parse_str($parts['query'], $vars);
            $id = $vars['v'] ?? null;
        } else {
            if ($parts['host'] == 'youtu.be') {
                $id = substr($parts['path'], 1);
            }
        }
    }

    return $id;
}

/**
 * @param $index
 * @return false|string
 */
function generate_random_date($index)
{
    $deltas = [['minutes' => 59], ['hours' => 23], ['days' => 6], ['weeks' => 4], ['months' => 11]];
    $dcnt = count($deltas);

    if ($index < 0) {
        $index = 0;
    }

    if ($index >= $dcnt) {
        $index = $dcnt - 1;
    }

    $delta = $deltas[$index];
    $timeval = rand(1, current($delta));
    $timename = key($delta);

    $ts = strtotime("$timeval $timename ago");
    $dt = date('Y-m-d H:i:s', $ts);

    return $dt;
}

/**
 * Функция для перевода времени поста в относительный формат
 * @param string $date Дата и время в формате Y-m-d H:i:s
 * @return string время в человеко-понятном формате
 */
function convert_date_relative_format($date)
{
    $sec = time() - strtotime($date);
    $min = $sec / 60;
    $hour = $min / 60;
    $day = $hour / 24;
    $week = $day / 7;
    $month = $week / 4;
    if ($sec <= 60) {
        $date = floor($sec);
        $date .= " " . get_noun_plural_form($date, "секунда", "секунды", "секунд");
    } elseif ($min < 60) {
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

    return $date;
}


/**
 * Функция для обрезки пользовательских постов с добавлением ссылки на полный текст поста
 * @param integer $id id поста
 * @param string $post текст поста
 * @param integer $lenght длина обрезки текста поста
 * @return string обрезанный текст с добавлением ссылки на полный текст
 */
function cropping_post($id, $post, $lenght = 300)
{
    if (strlen($post) >= $lenght) {
        $words_post = explode(" ", $post);
        $lenght_post = 0;
        for ($i = 0; $i < count($words_post); $i++) {
            $lenght_post += strlen($words_post[$i]);
            if ($lenght_post > $lenght) {
                break;
            }
        }
        $words_post = array_slice($words_post, 0, $i - 1);
        $post = implode(" ", $words_post);
        $post = "<p>" . $post . "...</p>";
        $post .= '<a class="post-text__more-link" href="post.php?id=' . $id . '">Читать далее</a>';
    } else {
        $post = "<p>" . $post . "</p>";
    }
    return $post;
}

/**
 * Функция загрузки файла с проверкой типа
 * @param string $file_tmp расположение временного файла
 * @return true|string
 */
function upload_file($file_tmp)
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $tmp_type = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);
    switch ($tmp_type) {
        case 'image/jpeg':
            $type_file = ".jpg";
            break;
        case 'image/png':
            $type_file = ".png";
            break;
        case 'image/gif':
            $type_file = ".gif";
            break;
        default:
            $type_file = false;
    }
    if ($type_file !== false) {
        $new_name = uniqid() . $type_file;
        move_uploaded_file($_FILES['uploadfile']['tmp_name'], "uploads/" . $new_name);
        return true;
    } else {
        return "Не верный тип файла.";
    }
}


/**
 * Функция для обрезки текста
 * @param string $text текст
 * @param integer $lenght длина обрезки текста
 * @return string обрезанный текст
 */
function cropping_text($text, $lenght = 100)
{
    if (strlen($text) >= $lenght) {
        $words_post = explode(" ", $text);
        $lenght_post = 0;
        for ($i = 0; $i < count($words_post); $i++) {
            $lenght_post += strlen($words_post[$i]);
            if ($lenght_post > $lenght) {
                break;
            }
        }
        $words_post = array_slice($words_post, 0, $i - 1);
        $text = implode(" ", $words_post);
        $text .= "...";
    }
    return $text;
}
