<?php
session_start();

require_once 'php/functions.php';
require_once 'php/connect.php';

$is_new_user = false;
$invalid_controls = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    /**
     * Сформировать массив не валидных полей, если таковые найдутся.
     */
    if (empty($login)) {
        $invalid_controls[] = 'login';
    }

    if (empty($pass)) {
        $invalid_controls[] = 'pass';
    }
    /**
     * Если данные введены без ошибок, сформировать пару логин/пароль для процедуры логина
     */
    if (empty($invalid_controls)) {
        $existing_user = db_findUserByLogin($DBH, $login);

        // Если впользователь с этим логином находится, то для авторизации сверяется пароль
        if (!empty($existing_user)) {
            $this_user = $existing_user[0];
            $verify = password_verify($pass, $this_user['pass']);

            if ($verify === true) {
                $_SESSION['user'] = $this_user;
                header('location: list.php');
                exit();
            } else {
                $invalid_controls[] = 'pass';
            }
        } else {
            // Если пользователь с этим e-mail не находится, выводится соответствующее сообщение
            $invalid_controls[] = 'login';
        }
    }
}

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

    <? echo renderTemplate('templates/nav.php') ?>

    <div class="container">

      <div class="form-container">
        <form class="form-horizontal"  method="post" name="login-form" action="index.php">
          <div class="form-group <?= in_array('login', $invalid_controls) ? 'has-error' : '' ?>">
            <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputEmail3" placeholder="Логин" name="login">
            </div>
          </div>
          <div class="form-group <?= in_array('pass', $invalid_controls) ? 'has-error' : '' ?>">
            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="inputPassword3" placeholder="Пароль" name="pass">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Войти</button>
              <br><br>
              Нет аккаунта? <a href="reg.php">Зарегистрируйтесь</a>
            </div>
          </div>
        </form>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script>

    </script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
