<?php
defined('VONZO') OR exit();
?>

	  <div class="section">
	      <div class="page-title-bold">
						Change Password
				</div>

				<div class="row no-padding">
					<div class="col-md-4 no-padding" style="padding-bottom:100px;">
						<form>

							<label for="r_current_password" class="global-row-spacing-top-small">Current Password</label>
							<input type="password" name="current_password" id="r_current_password" placeholder="Current Password" value="">

							<label for="r_new_password" class="global-row-spacing-top-small">New Password</label>
							<input type="password" name="new_password" id="r_new_password" placeholder="New Password" value="">

							<label for="r_confirm_new_password" class="global-row-spacing-top-small">Confirm New Password</label>
							<input type="password" name="conform_new_password" id="r_confirm_new_password" placeholder="Confirm New Password" value="">

							<div class="notification-box notification-box-error global-row-spacing-top-half form-return">
                  <p class="form-return-text-error"></p>
                  <div class="notification-close notification-close-error"></div>
              </div>

							<div class="notification-box notification-box-success global-row-spacing-top-half form-return">
                  <p class="form-return-text-success">Your password has successfully been updated.</p>
                  <div class="notification-close notification-close-success"></div>
              </div>

							<BR><BR>
							<div class="btn btn-border-outline global-row-spacing-top-small dark-text bold change-password">Save Changes</div>


						</form>
					</div>
				</div>

	  </div>
