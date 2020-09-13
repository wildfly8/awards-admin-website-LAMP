<div class="home-center">

		<div class="home-description">

				<h3 style="margin-bottom:20px;margin-top:20px;">Log In</h3>
				<form id="login-form" method="POST">
						<?=$this->token()?>
						<label for="i_email"><?=$lang['email']?></label>
						<input type="text" name="email" id="i_email" placeholder="<?=$lang['email']?>" value="<?=e(isset($data['email']) ? $data['email'] : '')?>" maxlength="32">

						<label for="i_password"><?=$lang['password']?></label>
						<input type="password" name="password" id="i_password" placeholder="<?=$lang['password']?>" maxlength="64">

						<div class="remember-me"><input type="checkbox" name="remember" id="i_remember" value="1" checked="checked"><label for="i_remember"><?=$lang['remember_me']?></label></div>

						<div class="notification-box notification-box-error form-return global-row-spacing-bottom-half">
								<p class="form-return-text"></p>
								<div class="notification-close notification-close-error"></div>
						</div>
						<img src="<?=$data['url']?>/<?=$data['theme_path']?>/<?=$data['settings']['site_theme']?>/assets/images/loading-spinner.gif" class="form-loader login-loader">

						<button type="submit" name="login" class="login-button"><?=$lang['login']?></button>
				</form>

				<p style="margin-top:20px;">Not registered yet? <a href="<?php echo $data['url']; ?>/register">Sign up here</a>.

		</div>

</div>
