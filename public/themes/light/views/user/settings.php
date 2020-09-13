<?php
defined('VONZO') OR exit();
?>

	  <div class="section">
	      <div class="page-title-bold">
						General Settings
				</div>

				<?php /*
				<BR><BR>
				name, address, email, phone
				<BR><BR>
				Notification email / sms on & off
				*/ ?>

				<div class="row no-padding">
					<div class="col-md-4 no-padding" style="padding-bottom:100px;">
						<form>

							<label for="r_full_name" class="global-row-spacing-top-small">Username</label>
							<input type="text" name="full_name" id="r_full_name" placeholder="Full Name" value="<?php echo $data['user']->username; ?>" disabled="disabled">

							<label for="r_email" class="global-row-spacing-top-small">Email <?php if ($data['user']->emailVerified != "Y") { echo '<span style="color:#ff0000;">(unverified)</span>'; } else { echo '<span style="color:#008f00;">(verified)</span>'; } ?></label>
							<input type="text" name="email" id="r_email" placeholder="Email" value="<?php echo $data['user']->email; ?>" disabled="disabled">

							<?php
							if ($data['user']->emailVerified != "Y") { ?>
								<label for="r_email_verification" class="global-row-spacing-top-small">Email Verification</label>
								<input type="text" name="email_verification" id="r_email_verification" placeholder="Email Verification Code">
								<small class="resend-email-verification-code">[resend email verification code]</small>
								<label class="email-verification-return label" style="display:none;"></label>
								<?php
							} ?>

							<?php
							/*

							<label for="r_phone" class="global-row-spacing-top-small">Phone (with country code) <?php if ($data['user']->phoneVerification != "Y") { echo '<span style="color:#ff0000;">(unverified)</span>'; } else { echo '<span style="color:#008f00;">(verified)</span>'; } ?></label>
							<input type="text" name="phone" id="r_phone" placeholder="Phone" value="<?php echo $data['user']->phone; ?>">

							<?php
							if ($data['user']->phone != "" && $data['user']->phoneVerification != "Y") { ?>
								<label for="r_phone_verification" class="global-row-spacing-top-small">Phone Verification</label>
								<input type="text" name="phone_verification" id="r_phone_verification" placeholder="Phone Verification Code">
								<small class="resend-phone-verification-code">[resend phone verification code]</small>
								<label class="phone-verification-return label" style="display:none;"></label>
								<?php
							} ?>

							*/
							?>

							<label style="height:0px;padding:0;">&nbsp;</label>

							<div class="notification-box notification-box-error global-row-spacing-top-small form-return">
                  <p class="form-return-text-error"></p>
                  <div class="notification-close notification-close-error"></div>
              </div>

							<div class="notification-box notification-box-success global-row-spacing-top-small form-return">
                  <p class="form-return-text-success">Your account has successfully been updated.</p>
                  <div class="notification-close notification-close-success"></div>
              </div>

							<div class="return-container form-return">

							</div>

							<label style="height:0px;padding:0;">&nbsp;</label>

							<!-- <div class="btn btn-border-outline global-row-spacing-top-small dark-text bold general-settings-submit">Save Changes</div> -->

							<input type="hidden" id="og_phone" value="<?php echo $data['user']->phone;?>">
							<input type="hidden" id="og_email" value="<?php echo $data['user']->email;?>">

						</form>

						<div class="global-row-spacing-top">
							<div class="page-title-bold" style="margin-bottom:14px;">
									Notification Settings
							</div>

							Email notifications
							<div class="switch-field">
								<input type="radio" id="radio-one" name="switch-email" class="switch-email" value="on" <?php if ($data['user']->emailNotifications == "Y") { echo 'checked'; } ?>/>
								<label for="radio-one">On</label>
								<input type="radio" id="radio-two" name="switch-email" class="switch-email" value="off" <?php if ($data['user']->emailNotifications == "N") { echo 'checked'; } ?> />
								<label for="radio-two">Off</label>
								<div class="email-notif-return switch-notif-return"></div>
							</div>

							<?php /*
							SMS text notifications
							<div class="switch-field">
								<input type="radio" id="radio-three" name="switch-sms" class="switch-sms switch-sms-on" value="on" <?php if ($data['user']->phoneNotifications == "Y") { echo 'checked'; } ?>/>
								<label for="radio-three">On</label>
								<input type="radio" id="radio-four" name="switch-sms" class="switch-sms switch-sms-off" value="off" <?php if ($data['user']->phoneNotifications == "N") { echo 'checked'; } ?> />
								<label for="radio-four">Off</label>
								<div class="phone-notif-return switch-notif-return"></div>
							</div>
						</div>
						*/ ?>



					</div>
				</div>

	  </div>
