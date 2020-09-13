<?php

namespace Vonzo\Models;

class Award extends Model {

	public function editAward($award_id, $award_name, $award_type) {
		$query = $this->db->prepare("UPDATE `award` SET `type` = ?, `name` = ? WHERE `id` = ?");
		$query->bind_param('ssi', $award_type, $award_name, $award_id);
		$query->execute();
		$query->close();

	}

	public function insertNewAward($xAwardShowYear, $xAwardShow, $award_name, $award_type) {
		$xAward = $this->getAwardByName($award_name);
		if ($xAward == false) {
			$status = 1;
			$query = $this->db->prepare("INSERT INTO `award` (`status`, `type`, `name`) VALUES (?, ?, ?);");
			$query->bind_param('iss', $status,	$award_type, $award_name);
			if (!$query->execute()) {
			 error_log("insertNewAward Execute failed: (" . $query->errno . ") " . $query->error);
			}
			$award_id = $query->insert_id;

			// award show year
			if ($xAwardShowYear['this_years_awards_id_array'] != "") {
				$awardShowYearAwardsArray = explode(",", $xAwardShowYear['this_years_awards_id_array']);
				if (! in_array($award_id, $awardShowYearAwardsArray)) {
					$newAwardShowLine = $xAwardShowYear['this_years_awards_id_array'] . "," . $award_id;
					$query = $this->db->prepare("UPDATE `z_award_show_year` SET `this_years_awards_id_array` = ? WHERE `id` = ?");
					$query->bind_param('si', $newAwardShowLine, $xAwardShowYear['id']);
					$query->execute();
					$query->close();
				}
			} else {
				$newAwardShowLine = $award_id;
				$query = $this->db->prepare("UPDATE `z_award_show_year` SET `this_years_awards_id_array` = ? WHERE `id` = ?");
				$query->bind_param('si', $newAwardShowLine, $xAwardShowYear['id']);
				$query->execute();
				$query->close();
			}

			// award show
			if ($xAwardShow['awards_array'] != "") {
				$awardShowYearAwardsArray = explode(",", $xAwardShow['awards_array']);
				if (! in_array($award_id, $awardShowYearAwardsArray)) {
					$newAwardShowLine = $xAwardShow['awards_array'] . "," . $award_id;
					$query = $this->db->prepare("UPDATE `z_award_show` SET `awards_array` = ? WHERE `id` = ?");
					$query->bind_param('si', $newAwardShowLine, $xAwardShow['id']);
					$query->execute();
					$query->close();
				}
			} else {
				$newAwardShowLine = $award_id;
				$query = $this->db->prepare("UPDATE `z_award_show` SET `awards_array` = ? WHERE `id` = ?");
				$query->bind_param('si', $newAwardShowLine, $xAwardShow['id']);
				$query->execute();
				$query->close();
			}
			//

		} else { // award already exisits

			// award show year
			if ($xAwardShowYear['this_years_awards_id_array'] != "") {
				$awardShowYearAwardsArray = explode(",", $xAwardShowYear['this_years_awards_id_array']);
				if (! in_array($xAward['id'], $awardShowYearAwardsArray)) {
					$newAwardShowLine = $xAwardShowYear['this_years_awards_id_array'] . "," . $xAward['id'];
					$query = $this->db->prepare("UPDATE `z_award_show_year` SET `this_years_awards_id_array` = ? WHERE `id` = ?");
					$query->bind_param('si', $newAwardShowLine, $xAwardShowYear['id']);
					$query->execute();
					$query->close();
				}
			} else {
				$newAwardShowLine = $xAward['id'];
				$query = $this->db->prepare("UPDATE `z_award_show_year` SET `this_years_awards_id_array` = ? WHERE `id` = ?");
				$query->bind_param('si', $newAwardShowLine, $xAwardShowYear['id']);
				$query->execute();
				$query->close();
			}

			// award show
			if ($xAwardShow['awards_array'] != "") {
				$awardShowYearAwardsArray = explode(",", $xAwardShow['awards_array']);
				if (! in_array($xAward['id'], $awardShowYearAwardsArray)) {
					$newAwardShowLine = $xAwardShow['awards_array'] . "," . $xAward['id'];
					$query = $this->db->prepare("UPDATE `z_award_show` SET `awards_array` = ? WHERE `id` = ?");
					$query->bind_param('si', $newAwardShowLine, $xAwardShow['id']);
					$query->execute();
					$query->close();
				}
			} else {
				$newAwardShowLine = $xAward['id'];
				$query = $this->db->prepare("UPDATE `z_award_show` SET `awards_array` = ? WHERE `id` = ?");
				$query->bind_param('si', $newAwardShowLine, $xAwardShow['id']);
				$query->execute();
				$query->close();
			}
			//
		}
	} // end insertNewAward

	public function getAwardByName($name) {
		$query = $this->db->prepare("SELECT * FROM `award` WHERE `name` = ?");
		$query->bind_param('s', $name);
		$query->execute();
		$result = $query->get_result();
		$query->close();
		if ($result->num_rows > 0) {
			return $result->fetch_assoc();
		}
		return false;
	}

	public function listAwardCheckboxesByAwardIdByArray($award_id_string, $this_years_awards_id_string) {
		$awards_id_array = explode(",", $award_id_string);
		$this_years_awards_id_array = explode(",", $this_years_awards_id_string);
		// need to sort alphabetically
		$columns = 0;
		for ($i = 0; $i < sizeof($awards_id_array); $i++) {
			$award_id = $awards_id_array[$i];
			$xAward = $this->getAwardById($award_id);
			if (trim($xAward['name']) != "") {
				$award_array_sorter[$xAward['id']] = trim($xAward['name']);
				$award_array_type[trim($xAward['name'])] = $xAward['type'];
				$columns++;
			}
		}

		asort($award_array_sorter);

		$report = "";
		$columns = floor($columns / 3);
		$columnCounter = 0;
		$divCloaseNeeded = 0;
		foreach ($award_array_sorter as $a_id => $a_name) {
			if ($columnCounter == 0) {
				$divCloaseNeeded++;
				$divCloaseNeeded++;
				$report .= '<div class="col-md-4" style="padding:0;"><div style="padding:12px;">';
			}

			$report .= '<input type="checkbox" class="checkbox award_checkbox" name="award_checkbox" value="'.$a_id.'"';
			if (in_array($a_id, $this_years_awards_id_array)) {
				$report .= 'checked';
			}
			$report .= '> <span id="award_name_text_'.$a_id.'">'.$a_name.'</span> - <span class="bold" style="text-decoration:none;" id="award_type_text_'.$a_id.'">'.$award_array_type[$a_name].'</span> <i class="fa fa-pencil edit_award_type" name="'.$a_id.'"></i><br>';

			$columnCounter++;
			if ($columnCounter == $columns) {
				$divCloaseNeeded--;
				$divCloaseNeeded--;
				$columnCounter = 0;
				$report .= '</div></div>';
			}
		}
		if ($divCloaseNeeded == 2) {
			$report .= '</div></div>';
		}
		return $report;
	}

	public function getAwardsByShowId($award_show_id) {
		if (isset($_GET['sort_column'])) {
			$sort_column = $_GET['sort_column'];
		} else {
			$sort_column = "type";
		}
		if (isset($_GET['sort_direction'])) {
			$sortDirection = $_GET['sort_direction'];
		} else {
			$sortDirection = "ASC";
		}
		if ($sortDirection == "ASC") {
			$sortDirectionOpposite = "DESC";
		} else {
			$sortDirectionOpposite = "ASC";
		}
		$query = 'SELECT * FROM `z_award_show` WHERE `id` = '.$award_show_id;
		$xAwardShow = mysqli_fetch_array(mysqli_query($this->db,$query));
		$awardsArray = explode(",", $xAwardShow['awards_array']);
		$awardQuery = 'SELECT * FROM `award` WHERE';
		for ($i = 0; $i < sizeof($awardsArray); $i++) {
			if ($awardQuery == 'SELECT * FROM `award` WHERE') {
				$awardQuery .= ' `id` = ' . $awardsArray[$i];
			} else {
				$awardQuery .= ' OR `id` = ' . $awardsArray[$i];
			}
		}
		$awardQuery .= ' ORDER BY '.$sort_column.' '.$sortDirection;
		// error_log($awardQuery);
		$report = '';
		$get_awards = mysqli_query($this->db, $awardQuery);
		while ($xAward = mysqli_fetch_array($get_awards)) {
			$thisDescription =  "<br><i>" . $xAward['description'] . '</i>';
			$noms = $this->countCategoryNoms($xAward['id']);
			$wins = $this->countCategoryWins($xAward['id']);
			$report .= '<tr bgcolor=white>
										<td>
											<font color=#666666>'.$xAward['id'].'</font>
										</td>
										<td>
											<a href="'.URL_PATH.'/admin/shows/'.$award_show_id.'/category/'.$xAward['id'].'">
											'.$xAward['name'].' '.$thisDescription.'</a>
										</td>
										<td>'.$xAward['type'].'</td>
										<td></td>
										<td>'.$noms.'</td>
										<td>'.$wins.'</td>
										<td>
											TODO Editing awards
										</td>
									 </tr>';
		}
		return $report;
	}

	function countCategoryNoms($award_id) {
		$query = 'SELECT COUNT(*) as total FROM `z_nominations` WHERE `award_id` = '.$award_id;
		$result = mysqli_query($this->db, $query);
		$data = mysqli_fetch_array($result);
		$count = $data['total'];
		return $count;
	}
	function countCategoryWins($award_id) {
		$query = 'SELECT COUNT(*) as total FROM `z_nominations` WHERE `award_id` = '.$award_id.' AND `status` = "Winner"';
		$result = mysqli_query($this->db, $query);
		$data = mysqli_fetch_array($result);
		$count = $data['total'];
		return $count;
	}

	public function getAwardById($award_id) {
		$query = $this->db->prepare("SELECT * FROM `award` WHERE `id` = ?");
		$query->bind_param('i', $award_id);
		$query->execute();
		$result = $query->get_result()->fetch_assoc();
		$query->close();
		return $result;

	}

}
