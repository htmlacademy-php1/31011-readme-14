<?php

function db_get_all ($link, $sql) {
    $result = mysqli_query($link, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error();
        print($error);
    }
}

function db_get_one ($link, $sql) {
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $array[0];
    } else {
        $error = mysqli_error();
        print($error);
    }
}

function db_update ($link, $sql) {
    $result = mysqli_query($link, $sql);
    if (!$result) {
        $error = mysqli_error();
        print($error);
    }
}
?>
