<?php
require_once 'functions.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ./');
}

if (isset($_POST['bday']) && getCurrentUser()!==null) {

    $users = json_decode(file_get_contents('users.json'),1);
    $id = array_search(getCurrentUser(), array_column($users, 'login'));

    $users[$id]["bday"] = strtotime($_POST['bday']);

    file_put_contents("users.json", json_encode($users));

    header("Location: ./");

}

if (isset($_GET['bday-unset'])) {

    $users = json_decode(file_get_contents('users.json'),1);
    $id = array_search(getCurrentUser(), array_column($users, 'login'));

    unset($users[$id]["bday"]);

    file_put_contents("users.json", json_encode($users));

    header("Location: ./");

}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Салон - Главная</title>
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
                    <?php if (getCurrentUser()===null) { ?>

                    <div class="login-btns">
                        <a href="./reg.php"><button class="btn btn-outline-danger">Регистрация</button></a>
                        <a href="./login.php"><button class="btn btn-outline-success">Вход</button></a>
                    </div>
                        
                    <?php }else{ ?>

                    <div class="login-btns">
                        <a href="#">Привет, <?php echo getCurrentUser();?>!</a>
                        <a href="?logout">Выйти</a>
                    </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <h2>Акции</h2>
            </div>
            <?php 
            if (getCurrentUser()!==null) {
                echo getPersonalOffer();
                echo getBdayOffer();
            }
            ?>
            <div class="col-xl-6">
                <div class="banner">
                    <div class="caption">Приведи друга</div>
                    <div class="description">
                    Приведи друга - получи скидку 5%
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="banner">
                    <div class="caption">Скидки за скидки</div>
                    <div class="description">
                    Выполни условия всех акций и получи дополнительную скидку 5%
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <h2>Услуги</h2>
                <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Услуга</th>
                    <th scope="col">Цена</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Какая-то услуга</td>
                    <td>1000р</td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Тоже услуга</td>
                    <td>1500р</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td>И еще услуга</td>
                    <td>2000р</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <h2>Фото</h2>
                <div class="photos">
                    <img src="https://mywishboard.com/thumbs/wish/l/a/p/600x0_pxljhwyemsjvfxdb_jpg_0bee.jpg" alt="ph">
                    <img src="https://krot.info/uploads/posts/2022-01/thumbs/1643594326_43-krot-info-p-relaks-komnata-65.jpg" alt="ph">
                    <img src="https://51.img.avito.st/640x480/5722482951.jpg" alt="ph">
                    <img src="https://i3.lbrd.ru/fileentry/get/origin/33/1b/5f6618a29bf0a0a18ea874518bad.jpeg" alt="ph">
                    <img src="https://mywishboard.com/thumbs/wish/l/a/p/600x0_pxljhwyemsjvfxdb_jpg_0bee.jpg" alt="ph">
                    <img src="https://krot.info/uploads/posts/2022-01/thumbs/1643594326_43-krot-info-p-relaks-komnata-65.jpg" alt="ph">
                    <img src="https://i3.lbrd.ru/fileentry/get/origin/33/1b/5f6618a29bf0a0a18ea874518bad.jpeg" alt="ph">
                    <img src="https://mywishboard.com/thumbs/wish/l/a/p/600x0_pxljhwyemsjvfxdb_jpg_0bee.jpg" alt="ph">
                </div>
            </div>
        </div>
    </div>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</html>