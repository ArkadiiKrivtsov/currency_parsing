<?php
if (isset($exception)) { ?>
    <div class="flash_message_error">
        <p><?=$exception?></p>
    </div>
<?php }
?>

<?php
if (isset($success_message)) { ?>
    <div class="flash_message_success">
        <p><?=$success_message?></p>
    </div>
<?php }
?>