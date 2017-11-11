<?php
session_start();

require_once('connect.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invalid_controls = [];
    $data = [];

    // валидация данных в POST
    foreach ($_POST as $name => $value) {
        $value = trim($value);
        if (empty($value)) {
            $invalid_controls[] = $name;
            $data['message'] = "Заполните все поля!";

        } elseif ($name === 'pass' && $value !== $_POST['pass2']) {
            $invalid_controls[] = 'pass';
            $invalid_controls[] = 'pass2';
            $data['message'] = "Пароли не совпадают!";
        } elseif ($name === 'age' && !filter_var($value, FILTER_VALIDATE_INT)) {
            $invalid_controls[] = 'age';
            $data['message'] = "Возраст должен быть числом!";
        }
    }

    // валидация данных в FILES
    if ($_FILES['photo']['error']) {
        $invalid_controls[] = 'photo';
        $data['message'] = "Загрузите фото!";
    }

    if (!empty($invalid_controls) || empty($_POST)) {
        $data['invalid_controls'] = $invalid_controls;
    } else {
        // если общая валидация прошла, начинается регистрация
        $userData = getUserDataFromPOST();

        $login = $_POST['login'];
        $existing_user = db_findUserByLogin($DBH, $login);

        if (empty($existing_user)) {
            $user_id = db_insertUser($DBH, $userData);
            $data['message'] = $user_id ? "Вы зарегистрированы!" : "Ошибка регистрации!";

            $img = verifyAndUploadImage('photo', $user_id);
            if ($img !== '') {
                db_setAvatar($DBH, $img, $user_id);
            }
        } else {
            $data['message'] = "Вы уже зарегистрированы!";
        }
    }

    $data = json_encode($data);
    echo $data;
}
