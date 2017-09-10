<?php
$ip = '127.0.0.1';
$db = 'users';
$db_user = 'root';
$pass = '';

try {
    $DBH = new PDO("mysql:host=$ip;dbname=$db", $db_user, $pass);
} catch (PDOException $e) {
    echo $e->getMessage();
}
