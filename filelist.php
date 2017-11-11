<?php
session_start();

require_once 'php/functions.php';
require_once 'php/connect.php';

if (!isset($_SESSION['user'])) {
    header('HTTP/1.0 403 Forbidden');
    die('Forbidden');
}

$this_user = $_SESSION['user'];
$files = readAllImages();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <? echo renderTemplate('templates/nav.php', []); ?>

    <div class="container">
    <h1>Запретная зона, доступ только авторизированному пользователю</h1>
      <h2>Информация выводится из списка файлов</h2>
      <table class="table table-bordered">
        <tr>
          <th>Название файла</th>
          <th>Фотография</th>
          <th>Действия</th>
        </tr>
        <?php foreach ($files as $file) : ?>
          <tr>
              <td><?= $file ?></td>
              <td><img src="photos/<?= $file ?>" width="100" alt="<?= $file ?>"></td>
              <td><a href="" onclick="remove_avatar('<?= $file ?>'); return false;">Удалить аватарку пользователя</a></td>
          </tr>
        <?php endforeach; ?>
      </table>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/remove_avatar.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
