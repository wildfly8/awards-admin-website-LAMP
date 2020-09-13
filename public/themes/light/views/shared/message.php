<?php
defined('VONZO') OR exit();
?>
<div class="notification-box notification-box-<?=$data['message']['type']?>">
    <p><?=e($data['message']['content'])?></p>
    <div class="notification-close notification-close-<?=$data['message']['type']?>"></div>
</div>
