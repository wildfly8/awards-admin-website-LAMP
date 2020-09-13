<?php
defined('VONZO') OR exit();
?>
<footer id="footer" class="footer<?php if(!$this->url[0]): ?> footer-home<?php endif ?>">
    <div class="footer-content">
        <div class="footer-menu">
            <div class="footer-element">
              &nbsp;
              <?php /*<a href="<?php echo $data['url']; ?>/test">Test</a>*/ ?>
            </div>
        </div>

        <div class="footer-info">
            <div class="footer-element"><?=sprintf($lang['copyright'], $data['year'], e($data['settings']['site_title']))?></div>
        </div>
    </div>
</footer>
