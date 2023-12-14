<?php
//require_once APP_DIR . '/src/user_creation_logic.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="shortcut icon" href= "assets/images/icon/favicon.png">

    <title>Добавить пользователя</title>
</head>
<body>
<!--Подключаем флеш сообщения-->
<?php
//require_once APP_DIR . PAGE_DIR . 'layout/flash_messages.php';
?>


<div class="create_user_block">
    <p>Добавление пользователя</p>
    <form class="auth_style" action="#" method="post">
        <label>Введите Имя и Фамилию</label>
        <input type="text" name="user_name" placeholder="Иван Иванов" required >

        <label>Укажите Email</label>
        <input type="email" name="user_email" placeholder="mail@example.ru" required >

        <label>Придумайте пароль</label>
        <input type="password" name="password" required >

        <label>Повторите пароль</label>
        <input type="password" name="confirm_password" required >

        <div class="create_user_button_block">
            <button class="user_button" type="submit" name="create_submit">Зарегистрироваться</button>
            <button class="user_button" onclick="window.location.href = '/';" name="redirect">Назад</button>
        </div>

    </form>
</div>

</body>
</html>
