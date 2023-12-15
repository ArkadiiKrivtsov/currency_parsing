<?php
$title = 'Регистрация';
require_once APP_DIR . PAGE_DIR . 'layout' . DIRECTORY_SEPARATOR . 'header.php';
//Подключаем флеш сообщения
require_once APP_DIR . PAGE_DIR . 'layout' . DIRECTORY_SEPARATOR . 'flash_messages.php';
?>

<div class="create_user_block">
    <p>Добавление пользователя</p>
    <form class="auth_style" action="/register" method="post">
        <label>Введите Имя и Фамилию</label>
        <input type="text" value="<?=$_SESSION['user_name'] ?? ''?>" name="name" placeholder="Иван Иванов" required >

        <label>Укажите Email</label>
        <input type="email" value="<?=$_SESSION['user_email'] ?? ''?>" name="email" placeholder="mail@example.ru" required >

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
