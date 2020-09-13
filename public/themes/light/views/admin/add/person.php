<?php
defined('VONZO') OR exit();
?>
<div class="section">

	<h4 class="page-title-bold mb-3 mt-0">Add a Person</h4>

	<div class="row" style="padding: 1em; background-color: rgba(0,100,200,0.3);">
			<div class="col-md-4">
				<p>
					<b>Full Name</b><br>
					<input type="text" id="p_full_name" disabled>
				</p>

				<p>
					<b>Name Suffix</b><br>
					<input type="text" class="person_name_change" id="p_suffix">
				</p>

				<p>
					<b>First Name *</b><br>
					<input type="text" class="person_name_change" id="p_first_name">
				</p>

				<p>
					<b>Middle Name</b><br>
					<input type="text" class="person_name_change" id="p_middle_name">
				</p>

				<p>
					<b>Last Name *</b><br>
					<input type="text" class="person_name_change" id="p_last_name">
				</p>

			</div>
			<div class="col-md-4">
				<p>
					<b>Date of Birth</b><br>
					<input type="text" id="p_dob">
				</p>

				<p>
					<b>Date of Death</b><br>
					<input type="text" id="p_dod">
				</p>

				<p>
					<b>Detailed Description</b><br>
					<textarea id="p_detailed_desc"></textarea>
				</p>

				<p>
					<b>Internal Notes</b><br>
					<textarea id="p_internal_notes"></textarea>
				</p>
			</div>

			<div class="col-12" style="padding-left:0;">

				<div class="alert alert-warning form-return mb-4">
					<i class="fa fa-exclamation-circle mr-1"></i> It looks like another person(s) has been found with the same or similar name:
					<div class="the-found">
					</div>
				</div>

				<div class="alert alert-danger form-return mb-4">
					<i class="fa fa-exclamation-circle mr-1"></i> <span id="alert-danger-text"></span>
				</div>

				<img src="<?php echo URL_PATH; ?>/themes/light/assets/images/loading-spinner.gif" id="form-loader" class="form-loader">

				<div class="custom-button add_person_submit" style="margin-left:0;">Add</div>
			</div>
	</div>

</div>

<script type="text/javascript">
// need this for on dynamic load
if (window.jQuery) {
	$( "#p_dob" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: "+2Y",
		minDate: "-100Y",
		yearRange: "-100:+2"
	});
	$( "#p_dod" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: "+2Y",
		minDate: "-100Y",
		yearRange: "-100:+2"
	});
}
</script>
