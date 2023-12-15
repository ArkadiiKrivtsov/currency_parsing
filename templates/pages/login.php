<?php
$title = 'Авторизация';
require_once APP_DIR . PAGE_DIR . 'layout' . DIRECTORY_SEPARATOR . 'header.php';
//Подключаем флеш сообщения
require_once APP_DIR . PAGE_DIR . 'layout' . DIRECTORY_SEPARATOR . 'flash_messages.php';
?>
<div class="auth_block">
    <p class="auth_block_head">Авторизация</p>
    <form class="auth_style" action="/login" method="post">
        <label>Email</label>
        <input type="email" name="email" value="<?=$_SESSION['login_email'] ?? ''?>" placeholder="Введите Ваш имейл" required >
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль" required >
        <div class="create_user_button_block">
            <button class="user_button" type="submit" name="auth_submit">Войти</button>
            <button class="user_button" onclick="window.location.href = '/register';" name="redirect">Зарегистрироваться</button>
        </div>
    </form>
</div>
</body>
</html>