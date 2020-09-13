<?php
defined('VONZO') OR exit();
?>

<div class="section">
  <div class="page-title-bold mb-3">
			Award Shows
	</div>

	<table border="1" cellpadding="5" cellspacing"1" width="100%" class="table-bordered">
		<thead>
			<tr bgcolor="#aaa">
				<th>Award Show Name</th>
				<th># of Ceremonies</th>
				<th>Visible To Public</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// foreach($data['shows'] as $xShow) {
			for($i = 0; $i < sizeof($data['shows']); $i++) {
				?>
				<tr bgcolor="white">
					<td><a href="<?php echo $data['url']; ?>/admin/shows/<?php echo $data['shows'][$i]['main']['id']; ?>"><?php echo $data['shows'][$i]['main']['full_name']; ?></a></td>
					<td><?php echo $data['shows'][$i]['ceremony_count'] ?></td>
					<td><?php echo $data['shows'][$i]['main']['visible_to_public']; ?></td>
				</tr>
				<?php
			} ?>
		</tbody>
	</table>

</div>
