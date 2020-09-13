<?php
defined('VONZO') OR exit();


echo '<div class="section">Registration Closed</div>';
/*
?>

<script src='https://www.google.com/recaptcha/api.js'></script>

    <div class="home-center">

        <div class="home-description">
          <?=$this->message()?>

          <h3 style="margin-bottom:20px;margin-top:20px;">Sign Up</h3>

          <form method="post" id="registration-form">
              <?=$this->token()?>
              <label for="r_username"><?=$lang['username']?></label>
              <input type="text" name="username" id="r_username" placeholder="<?=$lang['username']?>" value="<?=e(isset($data['username']) ? $data['username'] : '')?>" maxlength="32">

              <label for="r_username"><?=$lang['email']?></label>
              <input type="text" name="email" id="r_email" placeholder="<?=$lang['email']?>" value="<?=e(isset($data['email']) ? $data['email'] : '')?>" maxlength="32">

              <label for="r_password"><?=$lang['password']?></label>
              <input type="password" name="password" id="r_password" placeholder="<?=$lang['password']?>" maxlength="64">

              <label for="r_confirm-password">Confirm Password</label>
              <input type="password" name="password" id="r_confirm-password" placeholder="<?=$lang['confirm_password']?>" maxlength="64">

              <div class="g-recaptcha" data-sitekey="<?php echo GOOGLE_SITE_KEY; ?>" style="margin-bottom:5px;margin-top:20px;"></div>

              <div class="global-row-spacing-top global-row-spacing-bottom-small">
                <input type="checkbox" id="tos"> I agree to the <a href="<?php echo $data['url']; ?>/terms">terms of service</a>.
              </div>

              <div class="notification-box notification-box-error form-return">
                  <p class="form-return-text"></p>
                  <div class="notification-close notification-close-error"></div>
              </div>
              <img src="<?=$data['url']?>/<?=$data['theme_path']?>/<?=$data['settings']['site_theme']?>/assets/images/loading-spinner.gif" class="form-loader registration-loader">

              <button type="submit" name="register" class="register-button"><?=$lang['register']?></button>
          </form>

          <p style="margin-top:20px;"><a href="<?php echo $data['url']; ?>">Log in here</a>.

      </div>

    </div>
*/ ?>
