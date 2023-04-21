<?php
require_once 'functions.php';

if (getCurrentUser()!==null) header("Location: ./");

$alert = '';

// Попытка авторизации
if (isset($_POST['login'])) {

    if (checkPassword($_POST['login'], sha1($_POST['password']))) {

        $_SESSION['login'] = $_POST['login'];
        $_SESSION['authStatus'] = true;
        $_SESSION['authTime'] = time();
        header("Location: ./");

    }

    $alert = '<div class="alert alert-danger" role="alert">Неверная пара логин пароль</div>';

}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Салон - Вход</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-xl-3 logo">
                    <a href="./">
                        <img src="./assets/img/logo.png" alt="logo">
                        <span>Спа</span>Салон
                    </a>
                </div>
                <div class="col-xl-9">
                    <div class="login-btns">
                        <a href="./reg.php"><button class="btn btn-outline-danger">Регистрация</button></a>
                        <a href="./login.php"><button class="btn btn-outline-success">Вход</button></a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row login-form">
            <div class="col-xl-4 offset-4">
                <h1>Авторизация</h1>
                <?php echo $alert;?>
                <form method="post">
                    <input type="text" name="login" placeholder="Логин" required><br>
                    <input type="password" name="password" placeholder="Пароль" required><br>
                    <button class="btn btn-outline-primary" type="submit">Войти</button>
                </form>
                Или <a href="./reg.php">зарегистрироваться</a>
            </div>
        </div>
    </div>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</html>