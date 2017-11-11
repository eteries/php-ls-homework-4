<?php
session_start();

require_once('connect.php');
require_once('functions.php');

if(!isset($_SESSION['user']))
{
    header("HTTP/1.0 403 Forbidden");
    die('Forbidden');
}

if (!empty($_POST['img'])) {

    $img = $_POST['img'];

    if (remove_avatar($img)) {
        echo "Аватар удалён. ";

        $avatar_owner = db_findUserByAvatar($DBH, $img);

        if (!empty($avatar_owner = db_findUserByAvatar($DBH, $img))) {
            db_setAvatar($DBH, null, $avatar_owner[0]['id']);
            echo " Профиль пользователя обновлён.";
        }
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}




