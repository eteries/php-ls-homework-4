<!-- шаблон нав -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">РегистраторЪ</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?= setActiveClass(isURLActive('index.php')); ?>"><a href="index.php">Авторизация</a></li>
                <li class="<?= setActiveClass(isURLActive('reg.php')); ?>"><a href="reg.php">Регистрация</a></li>
                <?php if (isset($_SESSION['user'])) : ?>
                  <li class="<?= setActiveClass(isURLActive('list.php')); ?>"><a href="list.php">Список пользователей</a></li>
                  <li class="<?= setActiveClass(isURLActive('filelist.php')); ?>"><a href="filelist.php">Список файлов</a></li>
                <?php endif; ?>
            </ul>
            <span class="pull-right" style="color: #fff; line-height: 50px">
              <?php
                if (isset($_SESSION['user'])) {
                    echo $_SESSION['user']['name'];
                    echo ' | ';
                    echo '<a href="index.php">Выйти</a>';
                } else {
                    echo '<a href="logout.php">Войти</a>';
                }
              ?>
            </span>
        </div><!--/.nav-collapse -->
    </div>
</nav>