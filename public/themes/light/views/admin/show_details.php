<?php
defined('VONZO') OR exit();
?>

<div class="section">
  <h4 class="page-title-bold mb-3 mt-0">
			<?php echo $data['show']['full_name']; ?> <div class="custom-button edit_award_show_toggle btn btn-primary active inline" style="border:0;">Edit Award Show</div> <div class="custom-button add_new_show_year_button btn btn-primary inline">Add new Show Year</div>
	</h4>


	<div style="padding: 1em; background-color: rgba(0,100,200,0.3);">
    <div class="award_show_info_container">
      <div class="top-section-text">
        Award Show Info
      </div>
      <form method="post" style="width:300px;">
        <input type="hidden" id="edit_award_show_id" name="show_id" value="1">

        <p>Awards Show Full Name<br><input type="text" name="name" size="40" id="edit_award_show_full_name" value="<?php echo $data['show']['full_name']; ?>"></p>

        <p>Awards Show Short Name<br>
          <input type="text" name="nameShort" size="40" id="edit_award_show_short_name" value="<?php echo $data['show']['short_name']; ?>">
        </p>

        <p>Awards Show Abbreviation<br>
          <input type="text" name="nameAbbreviation" size="40" id="edit_award_show_abbreviation" value="<?php echo $data['show']['abbreviation']; ?>">
        </p>

        <p>Awards Show Website URL<br>
          <input type="text" name="websiteURL" size="40" id="edit_award_show_website_url" value="<?php echo $data['show']['show_website_url']; ?>">
        </p>

        <p>
          Visible to Public:<br>
          <input type="radio" name="edit_award_show_visible_to_public" class="edit_award_show_visible_to_public" value="Yes" <?php if ($data['show']['visible_to_public'] == "Yes") { echo 'checked'; } ?>> Yes / <input type="radio" name="edit_award_show_visible_to_public" class="edit_award_show_visible_to_public" value="No" <?php if ($data['show']['visible_to_public'] == "No") { echo 'checked'; } ?>> No
        </p>

        <div class="custom-button edit_award_show" style="margin-left:0;border:0;">Edit Award Show</div>

        </form>
      </div>



      <div class="add_new_show_year_container" style="display:none">
        <div class="top-section-text">
          Add new Show Year
        </div>
        <div class="row new-form">
          <div class="new-form-col col-md-5" style="padding-left:0;">
            <label>Title of this Year's Show *</label>
            <input type="text" id="asy_title" value="">

            <label class="label-margin-top">This Year's Show number *</label>
            <input type="text" id="asy_show_number" value="">

            <label class="label-margin-top">Eligibility Date Range *</label>
            <div style="display:block;margin-left:10px;">
              <span style="font-size:14px;display:block">From:</span>
              <input type="text" id="ns_eligibility_date_from">
              <span style="font-size:14px;display:block">To:</span>
              <input type="text" id="ns_eligibility_date_to">
            </div>

            <label class="label-margin-top">Ceremony Date *</label>
            <input type="text" id="ns_ceremony_date" value="" class="hasDatepicker">

            <label class="label-margin-top">Visible to Public *</label>
            <div style="display:block">
              <input type="radio" name="new_as_visible_to_public" class="new_as_visible_to_public" value="Yes"> Yes / <input type="radio" name="new_as_visible_to_public" class="new_as_visible_to_public" value="No"> No
            </div>

            <label class="label-margin-top">Year (existing)</label>
            <input type="text" id="asy_year_existing" value="">

            <label class="label-margin-top">Ceremony Date (existing)</label>
            <input type="text" id="asy_ceremony_date" value="">

            <label class="label-margin-top">Ceremony Year (existing)</label>
            <input type="text" id="asy_ceremony_year" value="">

          </div>

          <div class="new-form-col col-md-5">
            <label>Ceremony Venue</label>
            <input type="text" id="asy_ceremony_venue">

            <label class="label-margin-top">Host(s)</label>
            <input type="text" id="asy_hosts">

            <label class="label-margin-top">Network</label>
						<select id="ns_network_select" name="networks[]" multiple class="demo-default">
							<?php
							 foreach($data['networks'] as $network) {
								 echo '<option value="'.$network['company_name'].'">'.$network['company_name'].'</option>';
							 }
							 ?>
						</select>

            <label class="label-margin-top">Duration</label>
            <div style="display:block;">
              <input type="number" id="ns_hours" style="width:80px;"> hours <input type="number" id="ns_minutes" style="width:80px;"> minutes
            </div>

            <label class="label-margin-top">Viewership</label>
            <input type="text" id="asy_viewership">

            <label class="label-margin-top">Viewership Source</label>
            <input type="text" id="asy_viewship_source">

            <label class="label-margin-top">Add an initial internal note</label>
            <div style="display:block">
              <textarea id="asy_internal_notes" style="width:100%"></textarea>
            </div>

          </div>
        </div>

				<div class="row mt-4">
	        <div class="custom-button add_new_show_year_submit" style="margin-top:4px;margin-left:0;border:0;">Add new Show Year</div>
	        <div class="custom-button add_new_show_year_clear" style="margin-top:4px;margin-left:25px;border:0;">Clear</div>
				</div>


      </div>

  </div>




	<div class="top-section-text mt-4">
		Award Show Years
  </div>


	<table border="1" cellpadding="5" cellspacing"1" width="100%" class="table-bordered">
		<thead>
			<tr bgcolor="#aaa">
				<th><b>Year (existing)</b></th>
				<th><B>Eligability Date Range</b></th>
				<th><b>Show #</b></th>
				<th><b>Ceremony Date (existing)</b></th>
				<th><b>Ceremony Year (existing)</b></th>
				<th><b>Ceremony Date</b></th>
				<th><b>Categories, Noms, Wins</b></th>
				<th><b>Visible to Public</b></th>
				<th><b>Sample <i class='fa fa-edit change-sample-column'></i><BR><span class='sample-column-award-name'><?php echo $data['sample_name']; ?></span></b></th>
			</tr>
		</thead>
		<tbody>
			<?php
			for($i = 0; $i < sizeof($data['show_years']); $i++) {
				$xShowYear = $data['show_years'][$i]['main'];
        // echo $xShowYear['year_existing'];
				$theUrl = $data['url'] . '/admin/shows/' . $xShowYear['award_show_id'] . '/year/' . $xShowYear['id'];
				?>
				<tr bgcolor="white">
					<td>
						<a href="<?php echo $theUrl; ?>">
							<?php echo $xShowYear['year_existing']; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo $theUrl; ?>">
							<?php echo $xShowYear['eligibility_date_start'] . ' - ' . $xShowYear['eligibility_date_end']; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo $theUrl; ?>">
							<?php echo $xShowYear['show_year_number']; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo $theUrl; ?>">
							<?php echo $xShowYear['ceremony_date_existing']; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo $theUrl; ?>">
							<?php echo $xShowYear['ceremony_date_year_existing']; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo $theUrl; ?>">
							<?php echo $xShowYear['ceremony_date']; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo $theUrl; ?>">
							<?php echo $data['show_years'][$i]['categories'] . ' / ' . $data['show_years'][$i]['nominees'] . ' / ' . $data['show_years'][$i]['winners']; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo $theUrl; ?>">
							<?php echo $xShowYear['visible_to_public']; ?>
						</a>
					</td>
					<td>
            <?php
            if (isset($data['sample_nom_winners'][$i])) {
              echo $data['sample_nom_winners'][$i];
            } ?>
					</td>
				</tr>
				<?php
			} ?>
		</tbody>
	</table>



	<div class="top-section-text mt-4">
		Awards presented by this show
	</div>

	<table border="1" cellpadding="5" cellspacing"1" width="100%" class="table-bordered">
		<thead>
			<tr bgcolor="#aaa">
				<th><b>ID</b></th>
				<th><B>Name</b></th>
				<th><b>Type</b></th>
				<th><b>Years</b></th>
				<th><b>Nominees</b></th>
				<th><b>Winners</b></th>
				<th><b>Actions</b></th>
			</tr>
		</thead>
		<tbody>
			<?php echo $data['awards_list_html']; ?>
		</tbody>
	</table>

	<input type="hidden" id="getAwardShowId" value="<?php echo $data['show']['id']; ?>">

</div>

<div class="modal fade" id="change_sample_column_mod" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <?php
          echo $data['awardCheckboxes'];
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary change_sample_award">Change</button>
        <span class="change_sample_award_loading" style="display:none;">Loading...</span>
      </div>
    </div>
  </div>
</div>

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
