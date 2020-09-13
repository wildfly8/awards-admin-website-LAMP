<?php
defined('VONZO') OR exit();

$thisYear = $data['show_year']['year_existing'];
?>

<div class="section">
  <h4 class="page-title-bold mb-3 mt-0">
			<?php echo $data['show_year']['year_existing'] . ' ' . $data['show']['full_name']; ?> <div class="custom-button edit_award_show_year_toggle btn btn-primary active inline">Edit Award Show Year</div> <div class="custom-button edit_award_show_year_awards_toggle btn btn-primary inline">Edit Category List for this Award Show Year</div> <div class="custom-button award_show_year_notes_toggle btn btn-primary inline">Internal Notes</div>
	</h4>


	<div style='padding: 1em; background-color: rgba(0,100,200,0.3);'>

		<div class='edit_award_show_year_container'>
			<h4 class="mt-0 mb-2">Edit show information for <?php echo $thisYear; ?></h4>

			<div class='row'>
				<div class='col-md-4'>

					<p>
						<b>Title of this year's show *</b><br>
						<input type=text id='asy_title' size=30 value='<?php echo $data['show_year']['show_title']; ?>'>
					</p>

					<p>
						<b>This year's show number *</b><br>
						<input type=text id='asy_show_number' size=30 value='<?php echo $data['show_year']['show_year_number']; ?>'>
					</p>

					<p>
						<b>Year (existing)</b><br>
						<input type=text id='asy_year_existing' size=30 value='<?php echo $data['show_year']['year_existing']; ?>'>
					</p>

					<p>
						<b>Ceremony Year (existing)</b><br>
						<i>This is the year the awards for this year were presented at a formal ceremony</i><br>
						<input type=text id='asy_ceremony_date' size=30 value='<?php echo $data['show_year']['ceremony_date_year_existing']; ?>'>
					</p>

					<p>
						<b>Ceremony Date (existing)</b><br>
						<i>This is the date of the formal ceremony</i><br>
						<input type=text id='asy_ceremony_year' size=30 value='<?php echo $data['show_year']['ceremony_date_existing']; ?>'>
					</p>

				</div>
				<div class='col-md-4'>
					<?php
					$networkArray = explode(",", $data['show_year']['network']);
					?>
					<p>
						<b>Eligibility Date Range *</b>
						<span style="display:block;margin-left:10px;">
							<span style="font-size:14px;display:block;">From:</span>
							<input type="text" id="ns_eligibility_date_from" size=30 value="<?php echo $data['show_year']['eligibility_date_start']; ?>">
							<BR>
							<span style="font-size:14px;display:block;">To:</span>
							<input type="text" id="ns_eligibility_date_to" size=30 value="<?php echo $data['show_year']['eligibility_date_end']; ?>">
						</span>
					</p>

					<p>
						<b>Ceremony Date *</b><BR>
						<input type="text" id="ns_ceremony_date" size=30 value="<?php echo $data['show_year']['ceremony_date']; ?>">
					</p>

					<p>
						<b>Visible to Public *</b>
						<span style="display:block">
							<input type="radio" name="new_as_visible_to_public" id="new_as_visible_to_public" value="Yes" <?php if($data['show_year']['visible_to_public'] == "Yes") { echo 'checked="checked"'; } ?>> Yes / <input type="radio" name="new_as_visible_to_public" id="new_as_visible_to_public" value="No" <?php if($data['show_year']['visible_to_public'] == "No") { echo 'checked="checked"'; } ?>> No
						</span>
					</p>

					<p>
						<b>Ceremony Venue</b><BR>
						<input type="text" id="asy_ceremony_venue" size=30 value="<?php echo $data['show_year']['ceremony_venue']; ?>">
					</p>

					<p>
						<b>Host(s)</b><BR>
						<input type="text" id="asy_hosts" size=30 value="<?php echo $data['show_year']['hosts_array']; ?>">
					</p>

				</div>
				<div class="col-md-4">

					<p>
						<b>Network</b><BR>
						<select id="ns_network_select" name="networks[]" multiple class="demo-default">
							<?php
							 foreach($data['networks'] as $network) {
								 echo '<option value="'.$network['company_name'].'"';
								 if (in_array($network['company_name'], $networkArray)) {
									 echo 'selected';
								 }
								 echo '>'.$network['company_name'] . '</option>';
							 }
							 ?>
						</select>
					</p>

					<p>
						<b>Duration</b><BR>
						<span style="display:block;">
							<input type="number" id="ns_hours" style="width:80px;" value="<?php echo $data['show_year']['duration_hours']; ?>"> hours <input type="number" id="ns_minutes" style="width:80px;" value="<?php echo $data['show_year']['duration_minutes']; ?>"> minutes
						</span>
					</p>

					<p>
						<b>Viewership</b><BR>
						<input type="text" id="asy_viewership" size=30 value="<?php echo $data['show_year']['viewership']; ?>">
					</p>

					<p>
						<b>Viewership Source</b><BR>
						<input type="text" id="asy_viewship_source" size=30 value="<?php echo $data['show_year']['viewership_source']; ?>">
					</p>


				</div>
			</div>

			<div class="custom-button edit_show_year_submit" style="margin-left:0">Update this year show information</div>
		</div>

		<div class="award_show_year_categories_container" style="display:none;">

			<h4 class="mt-0 mb-2">Add or remove an existing category to <?php echo $thisYear; ?></h2>
			<div class="row" id="edit-award-existing-category">
				<?php echo $data['listAwardsChecklist']; ?>
			</div>

			<div class="custom-button" id="change-awards-submit" style="margin-left:0;margin-top:10px;">Update Awards for this Award Show Year</div>

      <fieldset style="margin-top:20px;">
        <legend>ATTACH A TOTALLY NEW CATEGORY TO THIS SHOW YEAR</legend>
  			<div class="row" style="padding-top:10px;">
            <div class="col-md-3">
  						<select class="award_type form-control">
                <option value="">Choose award type</option>
  							<option value="Title">Title</option>
  							<option value="Name - Actor">Name - Actor</option>
                <option value="Name - Craft">Name - Craft</option>
  							<option value="Song">Song</option>
  							<option value="Effect">Effect</option>
  							<option value="Commercial">Commercial</option>
  							<option value="Special">Special</option>
                <option value="Other">Other</option>
                <option value="Unknown">Unknown</option>
  						</select>
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control award_name" placeholder="Award name" style="padding:5px 8px;">
            </div>
            <div class="col-md-3" style="margin-top:2px;padding-left:0;">
  						<div class="custom-button add_new_award">Add New Award to <?php echo $thisYear; ?></div>
            </div>
  			</div>
			</fieldset>
		</div>

		<div class="award_show_year_notes_container" style="display:none;">
			<h4 class="mt-0 mb-2">Internal notes for <?php echo $thisYear; ?></h2>

			<div class="row">
				<div class="col-md-4">
					<p>
						<b>Internal notes</b><BR>
						<span style="display:block">
							<textarea id="asy_internal_notes_textarea" style="width:100%"></textarea>
						</span>
					</p>
					<div class="custom-button" id="award_show_year_notes_submit" style="margin-left:0;margin-top:0px;">Add Note</div>
				</div>
				<div class="col-md-1">&nbsp;</div>

				<div class="col-md-4 award_show_year_notes_list">
					<?php echo $data['theInternalNotes']; ?>
				</div>
			</div>


		</div>

	</div>


	<h4 class="mt-4 mb-3">All categories in this year's show - <?php echo 'Categories '.$data['category_count'].', Noms '.$data['nom_count'].', Winners '.$data['winner_count']; ?></h4>
	<?php echo $data['categoriesThisYear']; ?>


	<input type="hidden" id="award_show_year_id" value="<?php echo $data['show_year']['id']; ?>">



  <div class="modal fade" id="edit_award_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Award</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">

            <label>Award Name</label>
            <div class="form-control">
              <input type="text" id="edit_award_name_input" style="width:450px;">
            </div>

            <BR><BR>

            <label>Award Type</label>
            <select class="form-control" id="edit_award_type_input">
              <option value="">Choose award type</option>
              <option value="Title">Title</option>
              <option value="Name - Actor">Name - Actor</option>
              <option value="Name - Craft">Name - Craft</option>
              <option value="Song">Song</option>
              <option value="Effect">Effect</option>
              <option value="Commercial">Commercial</option>
              <option value="Special">Special</option>
              <option value="Other">Other</option>
              <option value="Unknown">Unknown</option>
            </select>

            <input type="hidden" id="edit_award_id_input">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary edit_award_info">Save</button>
          <span class="edit_award_info_loading" style="display:none;">Loading...</span>
        </div>
      </div>
    </div>
  </div>

</div> <!-- section -->

<script type="text/javascript">
// need this for on dynamic load
if (window.jQuery) {
$( "#ns_ceremony_date" ).datepicker({
	changeMonth: true,
	changeYear: true
});
$( "#ns_eligibility_date_from" ).datepicker({
	changeMonth: true,
	changeYear: true
});
$( "#ns_eligibility_date_to" ).datepicker({
	changeMonth: true,
	changeYear: true
});
$( "#p_dob" ).datepicker({
	changeMonth: true,
	changeYear: true,
	maxDate: "+2Y",
	minDate: "-100Y",
	yearRange: "-100:+2"
});

$('#ns_person_select').selectize();
$('#ns_project_select').selectize();
$('#ns_vendor_select').selectize();
$('#ns_product_select').selectize();
$('#ns_studio_select').selectize();
$('#ns_network_select').selectize();
}
</script>
