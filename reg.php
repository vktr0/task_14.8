<?php
require_once 'functions.php';

if (getCurrentUser()!==null) header("Location: ./");

$alert = '';

// Попытка регистрации
if (isset($_POST['login'])) {

    //Проверка пустых полей
    if ($_POST['login']=='' or $_POST['password']=='' or $_POST['password2']=='') {

        $alert = '<div class="alert alert-danger" role="alert">Заполните все поля</div>';

    //Если логин занят
    }elseif (existsUser($_POST['login'])) {

        $alert = '<div class="alert alert-danger" role="alert">Логин уже используется</div>';

    //Сверяем пароли
    }elseif ($_POST['password']!=$_POST['password2']) {

        $alert = '<div class="alert alert-danger" role="alert">Введенные пароли не совпали</div>';

    //Пишем пользователя
    }else{

        $users = json_decode(file_get_contents('users.json'),1);
        $users[] = [
            'login' => $_POST['login'],
            'password' => sha1($_POST['password']),
        ];

        file_put_contents("users.json", json_encode($users));
        
        header('Location: ./login.php');

    }

}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Салон - Регистрация</title>
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
                <h1>Регистрация</h1>
                <?php echo $alert;?>
                <form method="post">
                    <input type="text" name="login" placeholder="Логин" required><br>
                    <input type="password" name="password" placeholder="Пароль" required><br>
                    <input type="password" name="password2" placeholder="Повторите пароль" required><br>
                    <button class="btn btn-outline-primary" type="submit">Зарегистрироваться</button>
                </form>
                Или <a href="./login.php">войти</a>
            </div>
        </div>
    </div>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</html>