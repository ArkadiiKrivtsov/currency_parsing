<?php
require_once APP_DIR . '/src/auth.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href= "assets/css/main.css">
    <link rel="shortcut icon" href= "assets/images/icon/favicon.png">

    <title>Авторизация</title>
</head>
<body>
<!--Подключаем флеш сообщения-->
<?php
require_once APP_DIR . PAGE_DIR . 'layout/flash_messages.php';
?>
        <div class="auth_block">
            <p class="auth_block_head">Авторизация</p>
            <form class="auth_style" action="/login" method="post">
                <label>Email</label>
                <input type="email" name="email" placeholder="Введите Ваш имейл" required >

                <label>Пароль</label>
                <input type="password" name="password" placeholder="Введите пароль" required >

                <button class="auth_button" type="submit" name="auth_submit">Войти</button>
            </form>

        </div>

</body>
</html>