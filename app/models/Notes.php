<?php

namespace Vonzo\Models;

class Notes extends Model {

	public function getInternalNotes($type, $id) {
	  $xNotes = $this->getInternalNotesModel($type, $id);
		if ($xNotes) {
			$return = "";
			$return .= '
			<div class="table-responsive">
			<table class="table table-hover table-bordered" style="background-color:#fff;">
				<thead class="table-dark">
					<tr>
						<th>Date</th>
						<th>From</th>
						<th>Note</th>
					</tr>
				</thead>
				<tbody class="internal_notes_tbody">';
			while ($xNote = mysqli_fetch_array($xNotes)) {
				$return .= '
				<tr>
					<td>
						'.$xNote['created'].'
					</td>
					<td>
						Anonymous
					</td>
					<td>
						'.$xNote['the_note'].'
					</td>
				</tr>';
			}
		} else {
			$return = '<tr><td colspan="3">No internal notes.</td></tr>';
		}
		$return .= '</tbody></table></div>';
		return $return;

	}

	public function getInternalNotesModel($type, $id) {
		$result = mysqli_query($this->db, 'SELECT * FROM `z_internal_notes` WHERE `type` = "'.$type.'" AND `associated_id` = ' . $id . ' ORDER BY id DESC');
		// array_walk_recursive($result, '_clean');
		if($result) {
			return $result;
		}
		return false;
	}


}
