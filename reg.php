<?php
session_start();

require_once 'php/functions.php';
require_once 'php/connect.php';

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

      <div class="form-container">
        <form class="form-horizontal" method="post" name="reg-form" enctype="multipart/form-data">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
            <div class="col-sm-10">
              <input class="form-control" id="inputEmail3" name="login" placeholder="Логин">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
            <div class="col-sm-10">
              <input class="form-control" id="inputPassword3" name="pass" placeholder="Пароль">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">Пароль (Повтор)</label>
            <div class="col-sm-10">
              <input class="form-control" id="inputPassword4" name="pass2" placeholder="Пароль">
            </div>
          </div>
          <div class="form-group">
            <label for="inputText1" class="col-sm-2 control-label">Имя</label>
            <div class="col-sm-10">
              <input  class="form-control" id="inputText1" name="name" placeholder="Имя">
            </div>
          </div>
          <div class="form-group">
            <label for="inputText2" class="col-sm-2 control-label">Возраст</label>
            <div class="col-sm-10">
              <input class="form-control" id="inputText2"  name="age" placeholder="Возраст">
            </div>
          </div>
          <div class="form-group">
            <label for="textArea" class="col-sm-2 control-label">О себе</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="textArea" name="description" placeholder="Описания о себе"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="photo" class="col-sm-2 control-label">Фото</label>
            <div class="col-sm-10">
              <input type="file"  id="photo" name="photo">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Зарегистрироваться</button>
              <br><br>
              Зарегистрированы? <a href="index.php">Авторизируйтесь</a>
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
    <script src="js/form.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
