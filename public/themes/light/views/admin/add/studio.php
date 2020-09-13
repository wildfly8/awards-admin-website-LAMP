<?php
defined('VONZO') OR exit();
?>

<div class="section">

	<h4 class="page-title-bold mb-3 mt-0">Add a Studio</h4>

	<div class="row" style="padding: 1em; background-color: rgba(0,100,200,0.3);">
			<div class="col-md-4">
				<p>
					<b>Studio Name</b><br>
					<input type="text" id="studio_name">
				</p>

			</div>

			<div class="col-12" style="padding-left:0;">

				<div class="alert alert-warning form-return mb-4">
					<i class="fa fa-exclamation-circle mr-1"></i> It looks like another studio(s) has been found with the same or similar name:
					<div class="the-found">
					</div>
				</div>

				<div class="alert alert-danger form-return mb-4">
					<i class="fa fa-exclamation-circle mr-1"></i> <span id="alert-danger-text"></span>
				</div>

				<img src="<?php echo URL_PATH; ?>/themes/light/assets/images/loading-spinner.gif" id="form-loader" class="form-loader">

				<div class="custom-button add_studio_submit" style="margin-left:0;">Add</div>
			</div>

	</div>

</div>
