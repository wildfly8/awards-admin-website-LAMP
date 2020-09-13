<?php
defined('VONZO') OR exit();
?>

<div class="section">

	<h4 class="page-title-bold mb-3 mt-0">Add a Nomination</h4>


	<div class="row mt-4" style="padding: 1em; background-color: rgba(0,100,200,0.3);">
		<?php
		if ($data['award_show'] == false || $data['award_show_year'] == false || $data['award'] == false) {
			echo "No award show / award show year / award information was selected. How did you get to this page?";

		} else { ?>

			<div class="col-md-6">

				<p>
					<b>Award Show</b><br>
					<input type="text" id="nom_award_show"
						<?php
						if ($data['award_show'] != false) {
							echo ' disabled ';
							echo ' value="'.$data['award_show']['full_name'].'"';
						}
					  ?>>
				</p>

				<p>
					<b>Award Show Year Title</b><br>
					<input type="text" id="nom_award_show_year_title"
					<?php
					if ($data['award_show_year'] != false) {
						echo ' disabled ';
						echo ' value="'.$data['award_show_year']['show_title'].'"';
					}
					?>>
				</p>

				<p>
					<b>Award Show Year Ceremony Date</b><br>
					<input type="text" id="nom_award_show_year_title"
					<?php
					if ($data['award_show_year'] != false) {
						echo ' disabled ';
						echo ' value="'.$data['award_show_year']['ceremony_date'].'"';
					}
					?>>
				</p>

				<p>
					<b>Award Category</b><br>
					<input type="text" id="nom_award"
					<?php
					if ($data['award'] != false) {
						echo ' disabled ';
						echo ' value="'.$data['award']['name'].'"';
					}
					?>>
				</p>

				<p>
					<b>Award Type</b><br>
					<input type="text" id="nom_award"
					<?php
					if ($data['award'] != false) {
						echo ' disabled ';
						echo ' value="'.$data['award']['type'].'"';
					}
					?>>
				</p>

			</div>
			<div class="col-md-6">
				&nbsp;
			</div>


<?php /*
			<div class="row" style="border-top:1px solid #000;margin-top:30px;margin-left:0;width:300px;">
				<div class="col-md-6">
					&nbsp;
				</div>
			</div>
			<div class="row">

				<div class="col-md-6">
					<p>
						<b>Person</b><br>
						<input type="text" id="nom_award_show_year_title">
					</p>
				</div>
				<div class="col-md-6">
					<p>
						<b>Role</b><br>
						<input type="text" id="nom_award_show_year_title">
					</p>
					<u>[dynamically add person]</u>
				</div>

			</div>

			<div class="row">

				<div class="col-md-4">

					<p>
						<b>Project  (i.e. The Simpsons)</b><br>
						<input type="text" id="nom_title">
					</p>

					<p>
						<b>Sesason #</b><br>
						<input type="int" id="nom_season">
					</p>

					<p>
						<b>Episode #</b><br>
						<input type="int" id="nom_episode">
					</p>

					<p>
						<b>Episode Name</b><br>
						<input type="text" id="nom_episode_name">
					</p>

					<u>[dynamically add project]</u>

				</div>


				<div class="col-md-4">
					<p>
						<b>Network Name (Platform)</b><br>
						<input type="text" id="nom_network">
						<u>[dynamically add network]</u>
					</p>

					<p>
						<b>Studio Name (Production)</b><br>
						<input type="text" id="nom_studio">
						<u>[dynamically add studio]</u>
					</p>

					<p>
						<b>Vendor Name</b><br>
						<input type="text" id="nom_vendor">
						<u>[dynamically add vendor]</u>
					</p>

					<p>
						<b>Product Name</b><br>
						<input type="text" id="nom_product">
						<u>[dynamically add product]</u>
					</p>

					<p>
						<b>Song Name</b><br>
						<input type="text" id="nom_song">
						<u>[dynamically add song]</u>
					</p>

				</div>

			</div>

			<div class="row" style="border-top:1px solid #000;margin-top:30px;margin-bottom:20px;margin-left:0;width:300px;">
				<div class="col-md-6">
					&nbsp;
				</div>
			</div>
	*/ ?>

			<?php
			if ($data['award']['type'] == "Title") {
				$submitShow = true; ?>
				<table border="1" cellpadding="5" cellspacing"1" width="100%" class="table-bordered">
					<thead>
						<tr bgcolor="#aaa">
							<th>Title</th>
							<th>Network</th>
							<th>Studio</th>
						</tr>
					</thead>
					<tbody class="insert_nom_row_body">
						<?php
						for ($a = 0; $a < 6; $a++) { ?>
							<tr class="insert_nom_row" name="<?php echo $a; ?>">
								<td><input type="text" class="nom_name_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_network_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_studio_<?php echo $a; ?>"></td>
							</tr>
							<?php
						} ?>
					</tbody>
				</table>
				<div class="add_another_row_title mt-2" name="5">Add Another Row</div>

				<?php
				/////////////////////
			} else if ($data['award']['type'] == "Person - Actor") {
				$submitShow = true;
				?>
				<table border="1" cellpadding="5" cellspacing"1" width="100%" class="table-bordered">
					<thead>
						<tr bgcolor="#aaa">
							<th>Title</th>
							<th>Network</th>
							<th>Studio</th>
							<th>Name</th>
							<th>Job Title</th>
							<th>Character</th>
						</tr>
					</thead>
					<tbody class="insert_nom_row_body">
						<?php
						for ($a = 0; $a < 6; $a++) { ?>
							<tr class="insert_nom_row" name="<?php echo $a; ?>">
								<td><input type="text" class="nom_name_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_network_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_studio_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_name_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_job_title_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_character_<?php echo $a; ?>"></td>
							</tr>
							<?php
						} ?>
					</tbody>
				</table>

				<div class="add_another_row_person mt-2" name="5">Add Another Row</div>


				<?php
			} else if ($data['award']['type'] == "Person - Craft") {
				$submitShow = true;
				?>
				<table border="1" cellpadding="5" cellspacing"1" width="100%" class="table-bordered">
					<thead>
						<tr bgcolor="#aaa">
							<th>Title</th>
							<th>Network</th>
							<th>Studio</th>
							<th>Name</th>
							<th>Job Title</th>
							<th>Episode - Title</th>
							<th>Episode - #</th>
						</tr>
					</thead>
					<tbody class="insert_nom_row_body">
						<?php
						for ($a = 0; $a < 6; $a++) { ?>
							<tr class="insert_nom_row" name="<?php echo $a; ?>">
								<td><input type="text" class="nom_name_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_network_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_studio_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_name_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_job_title_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_episode_title_<?php echo $a; ?>"></td>
								<td><input type="text" class="nom_episode_number_<?php echo $a; ?>"></td>
							</tr>
							<?php
						} ?>
					</tbody>
				</table>

				<div class="add_another_row_person_craft mt-2" name="5">Add Another Row</div>

				<?php
			} else {
				$submitShow = false;
				echo 'Award Type not found. This may be a legacy award that needs to be updated. Maybe I\'ll put it here sometime soon? hmmm
				<BR><BR>Anyway look above this Award Type is "' . $data['award']['type'] . '" and the award types Ax3 use are:
				<BR>
			 	&nbsp; &bull; Title<BR>
				&nbsp; &bull; Name - Actor<BR>
				&nbsp; &bull; Name - Craft<BR>
			 	&nbsp; &bull; Song<BR>
			 	&nbsp; &bull; Effect<BR>
				&nbsp; &bull; Commercial<BR>
				&nbsp; &bull; Special<BR>
				&nbsp; &bull; Other<BR>
				&nbsp; &bull; Unknown<BR>';
			}

			if ($submitShow) {
				?>
				<div class="col-12" style="padding-left:0; margin-top:30px;">

					<div class="alert alert-danger form-return mb-4">
						<i class="fa fa-exclamation-circle mr-1"></i> <span id="alert-danger-text"></span>
					</div>

					<img src="<?php echo URL_PATH; ?>/themes/light/assets/images/loading-spinner.gif" id="form-loader" class="form-loader">

					<div class="custom-button" style="margin-left:0;">Add Nomination</div>
				</div>
				<?php
			}
		} ?>

	</div>

</div>
