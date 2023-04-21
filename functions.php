<?php
session_start();

function getUsersList() {

    $users = json_decode(file_get_contents('users.json'),1);

    for ($i=0; $i < count($users); $i++) { 

        $result[] = [
            'login' => $users[$i]['login'],
            'password' => $users[$i]['password'],
        ];

    }

    return $result;

}

function existsUser($login) {

    $users = getUsersList();
    return is_numeric(array_search($login, array_column($users, 'login')));

}

function checkPassword($login, $password) {

    if (!existsUser($login)) return false;

    $users = getUsersList();

    $user = $users[array_search($login, array_column($users, 'login'))];

    return $password===$user['password'];
    
}

function getCurrentUser() {

    return isset($_SESSION['authStatus']) ? $_SESSION['login'] : null;

}

function getPersonalOffer() {

    // Либо просто date('H:i:s', $secs)
    $secs = $_SESSION['authTime']+86400-time();
    
    $hours = floor($secs / 3600);
    $secs = $secs % 3600;

    $minutes = floor($secs / 60);
    $secs = $secs % 60;

    //Не показываем скидос если время вышло
    if ($secs<0) return false;

    $banner = '
    <div class="col-xl-6">
        <div class="banner">
            <div class="caption">Индивидуальная акция</div>
            <div class="description">
            Персональная скидка будет доступна '.$hours.' ч. '.$minutes.' мин. '.$secs.' сек
            </div>
        </div>
    </div>';

    return $banner;

}

function getBdayOffer() {

    $users = json_decode(file_get_contents('users.json'),1);
    $user = $users[array_search(getCurrentUser(), array_column($users, 'login'))];

    //Если нет дня рождения - спрашиваем
    if (!isset($user['bday'])) {

        $banner = '
        <div class="col-xl-6">
            <div class="banner">
                <div class="caption">Нужно больше информации</div>
                <div class="description">
                Для получения дополнительных скидок укажите свою дату рождения
                <form method="POST">
                    <input name="bday" value="дд.мм.гггг">
                    <button type="submit">Сохранить</button>
                </form>
                </div>
            </div>
        </div>';

    //Если день рождения сегодня - поздравляем
    }elseif (date('d.m', $user['bday'])==date('d.m')) {

        $banner = '
        <div class="col-xl-6">
            <div class="banner">
                <div class="caption">С днем рождения!</div>
                <div class="description">
                Счастья, здоровья и дарим скидку 5% на наши услуги
                <br><a href="?bday-unset">сбросить дату рождения</a>
                </div>
            </div>
        </div>';

    //Ждем
    }else{

        $secs = strtotime(date('d.m', $user['bday']).'.'.date('y'))-time();

        $days = floor($secs / 86400);
        $secs = $secs % 86400;
        
        $hours = floor($secs / 3600);

        $banner = '
        <div class="col-xl-6">
            <div class="banner">
                <div class="caption">Ждем день рождения</div>
                <div class="description">
                День рождения через '.$days.' д. '.$hours.' ч.
                <br><a href="?bday-unset">сбросить дату рождения</a>
                </div>
            </div>
        </div>';

    }

    return $banner;
    
}