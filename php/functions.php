<?php

/**
 * Добавляет в БД нового пользователя при помощи подготовленного выражения
 * и переданного массива данных. При успехе возвращает ID последней записи.
 *
 * @param pdo $DBH
 * @param array $data
 *
 * @return int|string
 */
function db_insertUser(pdo $DBH, array $data)
{
    $STH = $DBH->prepare("INSERT INTO users (login, name, pass, age, description) values (?, ?, ?, ?, ?)");
    $STH->execute($data);
    return $DBH->lastInsertId();
}


/**
 * Ищет в БД пользователя с переданым в качестве параметра login.
 * Возвращает массив с данными пользователя, либо пустой при неудаче
 *
 * @param pdo $DBH
 * @param string $email
 *
 * @return array
 */
function db_findUserByLogin(pdo $DBH, string $login) : array
{
    $STH = $DBH->prepare('SELECT * FROM users WHERE login = ?');
    $STH->execute([$login]);
    $data = [];

    while ($row = $STH->fetch()) {
        $data[] = $row;
    }
    return $data;
}

/**
 * Получает всех пользователей из БД в виде ассоциативного массива.
 *
 * @param pdo $DBH
 *
 * @return array
 */
function db_getAllUsers(pdo $DBH) : array
{
    $STH = $DBH->prepare('SELECT * FROM users');
    $STH->execute();
    $data = $STH->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

/**
 * Формирует из post запроса массив данных пользователя для последующей вставки в БД
 *
 * @return array
 */
function formUserFromPost() : array
{
    $user = [];

    $user[] = trim($_POST['login'] ?? '');
    $user[] = trim($_POST['name'] ?? '');
    $user[] = trim($_POST['pass'] ?? '');
    $user[] = trim($_POST['age'] ?? '');
    $user[] = trim($_POST['description'] ?? '');

    return $user;
}

/**
 * Принимает изображение из формы и в случае валидации записывает постоянный путь загруженному изображению.
 *
 * @param string $filename
 * @param int $id
 *
 * @return string
 */
function verifyAndUploadImage(string $filename, int $id) : string
{
    $img = '';

    if (isset($_FILES[$filename]) && $_FILES[$filename]['error'] == 0) {
        $original_name = $_FILES[$filename]['name'];
        $temp_name = $_FILES[$filename]['tmp_name'];
        $dir = '../photos/';

        $mimes = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif'
        ];

        $f_info = new finfo;
        $file_info = $f_info->file($temp_name, FILEINFO_MIME_TYPE);

        $check = array_search($file_info, $mimes, true);
        $extension = pathinfo($original_name, PATHINFO_EXTENSION);
        $allowed = array_keys($mimes);

        // Проверка  соответствия MIME и заявленного расширения разрешенным, загрузка с новым именем в случае успеха
        if ($check !== false && in_array($extension, $allowed)) {
            $file_path = $dir.$id.'.'.$check;
            $uploaded = move_uploaded_file($temp_name, $file_path);
        }

        if (isset($uploaded) && $uploaded === true) {
            $img =  $file_path;
        }
    }
    return $img;
}
