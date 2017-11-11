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
    try {
        $STH = $DBH->prepare("INSERT INTO users (login, name, pass, age, description) values (?, ?, ?, ?, ?)");
        $STH->execute($data);
        return $DBH->lastInsertId();
    } catch (pdoexception $exception) {
        return false;
    }
}

/**
 * Удаляет пользователя из БД по переданному логину.
 *
 * @param pdo $DBH
 * @param string $login
 *
 * @return bool
 */
function db_deleteUser(pdo $DBH, string $login)
{
    $STH = $DBH->prepare("DELETE FROM users WHERE login = ?");
    return $STH->execute([$login]);
}

/**
 * Ищет в БД пользователя с переданым в качестве параметра login.
 * Возвращает массив с данными пользователя, либо пустой при неудаче
 *
 * @param pdo $DBH
 * @param string $login
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
 * Ищет в БД пользователя с переданым в качестве параметра именем файлом изображения.
 * Возвращает массив с данными пользователя, либо пустой при неудаче
 *
 * @param pdo $DBH
 * @param string $img
 *
 * @return array
 */
function db_findUserByAvatar(pdo $DBH, string $img) : array
{
    $STH = $DBH->prepare('SELECT * FROM users WHERE img = ?');
    $STH->execute([$img]);
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
 * Получает все изображения из БД в виде ассоциативного массива.
 *
 * @param pdo $DBH
 *
 * @return array
 */
function db_getAllAvatars(pdo $DBH) : array
{
    $STH = $DBH->prepare('SELECT img FROM users');
    $STH->execute();
    $data = $STH->fetchAll(PDO::FETCH_COLUMN);

    return $data;
}

/**
 * Формирует из post запроса массив данных пользователя для последующей вставки в БД
 *
 * @return array
 */
function getUserDataFromPOST() : array
{
    $user = [];

    $user[] = trim(htmlspecialchars($_POST['login']) ?? '');
    $user[] = trim(htmlspecialchars($_POST['name']) ?? '');
    $user[] = password_hash(trim($_POST['pass'] ?? ''), PASSWORD_BCRYPT);
    $user[] = convertAgeToDateTime(trim(htmlspecialchars($_POST['age']) ?? ''));
    $user[] = trim(htmlspecialchars($_POST['description']) ?? '');

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
            $img =  pathinfo($file_path, PATHINFO_BASENAME);
        }
    }
    return $img;
}

/**
 * Устанавливает (или удаляет) аватар пользователя, обновляя его запись в БД
 *
 * @param pdo $DBH
 * @param string | null $img
 * @param int $id
 *
 * @return Exception|int|pdoexception
 */
function db_setAvatar(pdo $DBH, $img, int $id)
{
    try {
        $STH = $DBH->prepare("UPDATE users SET img='$img' WHERE id=$id");
        $STH->execute();
        return $STH->rowCount();
    } catch (pdoexception $exception) {
        return $exception;
    }
}

/**
 * Удаляет переданный файл из папки изображений
 *
 * @param string $img
 *
 * @return bool
 */
function remove_avatar(string $img)
{
    return $result = unlink('../photos/'.$img);
}

/**
 * Возвращает массив изображений из соответствующей папки
 *
 * @return array
 */
function readAllImages()
{
    return array_diff(scandir('photos'), array('.', '..'));
}

/**
 * Переводит возраст, вводимый пользователем в условную дату рождения для хранения в БД.
 *
 * @param $age
 * @return string
 */
function convertAgeToDateTime($age) : string
{
    return date('Y-m-d', strtotime("-$age years"));
}

/**
 * Восстановливает число полных лет по хранимой в БД дате
 *
 * @param $age
 *
 * @return string
 */
function convertDateToAge($date) : string
{
    return intval((time() - strtotime($date)) / (60 * 60 * 24 * 30 * 12));
}

/**
 * Формирует строку для вставки шаблона и соответствующих ему данных
 *
 * @param string $filename
 * @param array $data
 *
 * @return string
 */
function renderTemplate(string $filename, array $data = []) : string
{
    $__filename = $filename;

    if (!file_exists($filename)) {
        return '';
    }

    array_walk_recursive($data, function (&$item) {
        $item = htmlspecialchars($item);
    });

    extract($data);

    ob_start();

    include $__filename;

    return ob_get_clean();
}

/**
 * Проверяет является ли переданная страница активной
 *
 * @param string $page
 *
 * @return bool
 */
function isURLActive(string $page) : bool
{
    $location = explode('/', $_SERVER['REQUEST_URI']);
    $location_page = end($location);
    if ($location_page == '' && $page == 'index.php') {
        return true;
    }
    else {
        return $location_page == $page;
    }
}

/**
 * Возвращает активный класс, если проверка пройдена
 *
 * @param bool $isActive
 * @return string
 */
function setActiveClass(bool $isActive) : string
{
    return $isActive ? 'active' : '';
}

