<?php
$title = '404';
require_once APP_DIR . PAGE_DIR . 'layout' . DIRECTORY_SEPARATOR . 'header.php';
?>
<div class="error_404">
    <h1>OPS!</h1>
    <img src="assets/images/not_found.png" width="10%" alt="Изображение с ошибкой">
    <p><?=$e->getMessage()?></p>
</div>

</body>
</html>