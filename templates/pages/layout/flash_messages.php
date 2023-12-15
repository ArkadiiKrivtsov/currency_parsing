<?php
if (isset($_SESSION['error_message'])) { ?>
    <div class="flash_message_error">
        <p><?=$_SESSION['error_message']?></p>
    </div>
<?php }
    unset($_SESSION['error_message']);
?>

<?php
if (isset($success_message)) { ?>
    <div class="flash_message_success">
        <p><?=$success_message?></p>
    </div>
<?php }
?>