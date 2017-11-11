<?php
session_start();

require_once('connect.php');
require_once('functions.php');

if(!isset($_SESSION['user']))
{
    header("HTTP/1.0 403 Forbidden");
    die('Forbidden');
}

$ok = false;

// $ok won't toggle unless removing succeed
(function($DBH, &$ok) {
    if (!isset($_POST['login'])) {
        return;
    }
    $login = $_POST['login'];
    $existing_user = db_findUserByLogin($DBH, $login)[0];
    $this_user = $_SESSION['user'];

    // user did not found or he's trying remove himself
    if (empty($existing_user) || ($existing_user['login'] === $this_user['login'])) {
        return;
    }

    $img_to_remove = $existing_user['img'];

    if (true === $remove_user = db_deleteUser($DBH, $login)) {
        echo "Пользователь удалён";
        remove_avatar($img_to_remove);
        $ok = true;
    }
})($DBH, $ok);

if ($ok === false) {
    http_response_code(404);
}


