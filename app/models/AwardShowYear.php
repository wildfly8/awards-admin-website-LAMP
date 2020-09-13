<?php

namespace Vonzo\Models;

class AwardShowYear extends Model {


	function getAwardCheckboxes($awardModel, $awardShowModel, $show_id, $xAwardSampleName) {
		$xAwardShow = $awardShowModel->getShowById($show_id);
		$awards_id_array = explode(",", $xAwardShow['awards_array']);
		$theSampleName = "";
		// need to sort alphabetically
		$columns = 0;
		for ($i = 0; $i < sizeof($awards_id_array); $i++) {
			$award_id = $awards_id_array[$i];
			$xAward = $awardModel->getAwardById($award_id);
			if ($xAward['name'] != "") {
				$award_array_sorter[$xAward['id']] = trim($xAward['name']);
				$columns++;
			}
		}

		asort($award_array_sorter);

		$report = "";
		$columns = floor($columns / 3);
		$columnCounter = 0;
		foreach ($award_array_sorter as $a_id => $a_name) {
			if ($columnCounter == 0) {
				$report .= '<div class="col-md-4" style="padding:0;"><div style="padding:12px;">';
			}

			$report .= '<input type="radio" name="select_sample_award_radio" value="'.$a_id.'"';
			if ($xAwardSampleName == $a_id) {
				$report .= 'checked';
			}
			$report .= '> '.$a_name.'<br>';

			if ($xAwardSampleName == $a_id) {
				$theSampleName = $a_name;
			}

			$columnCounter++;
			if ($columnCounter == $columns) {
				$columnCounter = 0;
				$report .= '</div></div>';
			}
		}
		return array($report, $theSampleName);
	}

	public function listAwardsInShowYearFromArray($personModel, $projectModel, $vendorModel, $studioModel, $awardModel, $xAwardShow, $show_id, $show_year_id, $show_year, $awards_id_string, $summary) {
		$list = "";
		$awards_id_array = explode(",", $awards_id_string);
		$category_count = sizeof($awards_id_array);
		$nom_count = 0;
		$winner_count = 0;
		for ($i = 0; $i < sizeof($awards_id_array); $i++) {
				$award_id = $awards_id_array[$i];
				if ($award_id != "") {
					$xAward = $awardModel->getAwardById($award_id);
					$countNominees = $this->countNomineesShowYearAwardNew($show_id, $show_year, $award_id);
					$countWinners = $this->countWinnersShowYearAwardNew($show_id, $show_year, $award_id);

					$nom_count = $nom_count + $countNominees;
					$winner_count = $winner_count + $countWinners;
					// error_log($summary);
					if ($summary == false) {
						if ($countNominees == 0 && $countWinners == 0) {
							$details = "| Needs info! |"; //" <a href=?show=$show_id&year=$show_year&action=removeCategory&category=$award_id style='color: red !important'>Remove category from this year</a>";
						} else {
							$details = '('.$countNominees.' N / '.$countWinners.' W) | <a href="'.URL_PATH.'/admin/shows/'.$show_id.'/year/'.$show_year_id.'/category/'.$award_id.'/?nexty='.$awards_id_string.'">Review Noms</a>';
							// index.php?view=category&show=$show_id&year=$show_year&category=$award_id&nexty=".$awards_id_string.">Review noms</a>";
						}
						$list .= '<li style="margin-bottom:5px;"><b>'.$xAward['name'].'</b> '.$details.' | <a href="'.URL_PATH.'/admin/add/nomination/?show_id='.$show_id.'&show_year_id='.$show_year_id.'&award_id='.$award_id.'">Add noms</a>';
						 //"?show=$show_id&year=$show_year&award=$award_id>Add noms</a>";

						if ($countWinners != 0) {
							$list .= " | " . $this->getNomineesPage($personModel, $projectModel, $vendorModel, $studioModel, $xAward, $xAwardShow, $show_year_id, $show_id, $show_year, $award_id, true);
						}

					} else {
						// summary
						if ($countNominees == 0 && $countWinners == 0) {
							$list .= $thiis->getNomineesPage($personModel, $projectModel, $vendorModel, $studioModel, $xAward, $xAwardShow, $show_year_id, $show_id, $show_year, $award_id, true);
						}

					}

					$list .= "</li>";
				}
		}
		// error_log($list);
		return array($list, $category_count, $nom_count, $winner_count);
	}

	public function getNomineesPage($personModel, $projectModel, $vendorModel, $studioModel, $xAward, $xAwardShow, $show_year_id, $show_id, $show_year, $award_id, $winner_only) {

		$recap = "";
		if (! isset($show_year) || $show_year == 0) {
			$previousYear = 0;
			$show_year_id_flag = 0;
			$xNomRows = $this->getNominationAllRowsNoNominationIdNoYear($show_id, $award_id);
		} else {
			$previousYear = $show_year;
			$show_year_id_flag = $show_year;
			$xNomRows = $this->getNominationAllRowsNoNominationId($show_id, $show_year, $award_id);
		}


		while($xNom = mysqli_fetch_array($xNomRows)) {
			$projectIdArray = explode(",", $xNom['project_id_array']);
			$personIdArray = explode(",", $xNom['person_id_array']);
			$studioIdArray = explode(",", $xNom['studio_id_array']);
			$vendorIdArray = explode(",", $xNom['vendor_id_array']);

			if ($previousYear == 0 && $winner_only == false|| $previousYear != $xNom['show_year'] && $winner_only == false) {
				$previousYear = $xNom['show_year'];
				$recap .= '<h5 class="mt-3">' . $xNom['show_year'] . '</h5>';
			}

			$person = "";
			if (sizeof($personIdArray) > 0) {
				for($i = 0; $i < sizeof($personIdArray); $i++) {
					if ($personIdArray[$i] != "") {
						$xPerson = $personModel->doesPersonExistById($personIdArray[$i]);
						if ($person == "") {
							$person = '<a href="'.URL_PATH.'/admin/people/'.$xPerson['id'].'">'.$xPerson['full_name'].'</a>';
						} else {
							$person .= ', <a href="'.URL_PATH.'/admin/people/'.$xPerson['id'].'">'.$xPerson['full_name'].'</a>';
						}
					}
				}
			}
			$project = "";
			if (sizeof($projectIdArray) > 0) {
				for($i = 0; $i < sizeof($projectIdArray); $i++) {
					if ($projectIdArray[$i] != "") {
						$xProject = $projectModel->doesProjectExistById($projectIdArray[$i]);
						if ($project == "") {
							$project = '<a href="'.URL_PATH.'/admin/projects/'.$xProject['id'].'">'.$xProject['title_name'].'</a>';
						} else {
							$project .= ', <a href="'.URL_PATH.'/admin/projects/'.$xProject['id'].'">'.$xProject['title_name'].'</a>';
						}
					}
				}
			}
			$vendor = "";
			if (sizeof($vendorIdArray) > 0) {
				for($i = 0; $i < sizeof($vendorIdArray); $i++) {
					if ($vendorIdArray[$i] != "") {
						$xVendor = $vendorModel->doesVendorExistById($vendorIdArray[$i]);
						if ($vendor == "") {
							$vendor = '<a href="'.URL_PATH.'/admin/vendors/'.$xVendor['id'].'">'.$xVendor['company_name'].'</a>';
						} else {
							$vendor .= ', <a href="'.URL_PATH.'/admin/vendors/'.$xVendor['id'].'">'.$xVendor['company_name'].'</a>';
						}
					}
				}
			}
			$studio = "";
			if (sizeof($studioIdArray) > 0) {
				for($i = 0; $i < sizeof($studioIdArray); $i++) {
					if ($studioIdArray[$i] != "") {
						$xStudio = $studioModel->doesStudioExistById($studioIdArray[$i]);
						if ($studio == "") {
							$studio = '<a href="'.URL_PATH.'/admin/studios/'.$xStudio['id'].'">'.$xStudio['company_name'].'</a>';
						} else {
							$studio .= ', <a href="'.URL_PATH.'/admin/studios/'.$xStudio['id'].'">'.$xStudio['company_name'].'</a>';
						}
					}
				}
			}

			// TODO $network $notes
			if ($winner_only == true && $xNom['status'] == "Winner") {
				// if ($xAward['type'] == "Project") {
					// $recap .= "<b>".$xNom['status'].": </b> $project";
				// } else if($xAward['type'] == "Person") {
				// if ($xNom['show_year'] == $show_year) {
					$recap .= "<b>".$xNom['status'].": </b> ".$person." in ".$project . " ";
				// }
			} else if ($winner_only == false) {
				$recap .= "<li><b>".$xNom['status']."</b> $person <span class='bold' style='text-decoration:none;'>$project</span> $vendor $studio";
				if ($show_year_id_flag == 0) {
					$xAwardShowYear = $this->getByShowIdAndYear($show_id, $xNom['show_year']);
					$show_year_id = $xAwardShowYear['id'];
				}
				$recap .= ' | <a href="'.URL_PATH.'/admin/shows/'.$show_id.'/year/'.$show_year_id.'/category/'.$award_id.'/nomination/'.$xNom['id'].'">Edit</a>';
			}

		}

		if ($winner_only == false) {
			// Prepare the winner toggle
			if ($show_year == 0) {
				$page = '<h6>Category '.$award_id.' in All Years</h6>';
				$page .= '<h4 class="page-title-bold mb-3 mt-0">Nominees at the <a href="'.URL_PATH.'/admin/shows/'.$show_id.'">'.$xAwardShow['full_name'].'</a> for '.$xAward['name'].'</h4><p>'.$recap;

			} else {
				$page = '<h6>Category '.$award_id.' in '.$show_year.'</h6>';
				$page .= '<h4 class="page-title-bold mb-3 mt-0">Nominees at the <a href="'.URL_PATH.'/admin/shows/'.$show_id.'/year/'.$show_year_id.'">'.$show_year.' '.$xAwardShow['full_name'].'</a> for '.$xAward['name'];
				if (isset($_GET['nexty'])) {
					$nexty_array = explode(",", $_GET['nexty']);
					for ($i = 0; $i < sizeof($nexty_array); $i++) {
						if ($nexty_array[$i] == $award_id) {
							$nexty = $nexty_array[$i+1];
							if ((sizeof($nexty_array)-1) == $i) {
								$nexty = $nexty_array[0];
							}
						}

					}
					if (isset($nexty)) {
						$page .= ' <a href="'.URL_PATH.'/admin/shows/'.$show_id.'/year/'.$show_year_id.'/category/'.$nexty.'/?nexty='.$_GET['nexty'].'">[next award]</a>';
					}
				}
				 $page .= '</h4><p>'.$recap;
			}
		} else {
			$page = $recap;
		}

		return $page;

	} // end getNomineesPage

	public function getAwardShowYearsByShowId($show_id) {
		$query = $this->db->prepare("SELECT * FROM `z_award_show_year` WHERE `award_show_id` = ? ORDER BY `year_existing` DESC");
    $query->bind_param('i', $show_id);
		$query->execute();
		$result = $query->get_result();
		$query->close();
		$data['show_years'] = array();
		$i = 0;
		foreach($result as $xShowYear) {
			// error_log($xShowYear['year_existing']);
			$data['show_years'][$i]['main'] = $xShowYear;
			$data['show_years'][$i]['nominees'] = $this->countNomineesInShowYearNew($show_id, $xShowYear['year_existing']);
			$data['show_years'][$i]['winners'] = $this->countWinnersInShowYearNew($show_id, $xShowYear['year_existing']);
			$categoriesArray = explode(",", $xShowYear['this_years_awards_id_array']);
			$data['show_years'][$i]['categories'] = sizeof($categoriesArray);

			$i++;
		}
		return $data['show_years'];

	}

	public function getShowYearById($show_year_id) {
		$query = $this->db->prepare("SELECT * FROM `z_award_show_year` WHERE `id` = ?");
		$query->bind_param('i', $show_year_id);
		$query->execute();
		$result = $query->get_result()->fetch_assoc();
		$query->close();
		return $result;
	}
	public function getByShowIdAndYear($show_id, $show_year) {
		$query = $this->db->prepare("SELECT * FROM `z_award_show_year` WHERE `award_show_id` = ? AND `year_existing` = ?");
		$query->bind_param('is', $show_id, $show_year);
		$query->execute();
		$result = $query->get_result()->fetch_assoc();
		$query->close();
		return $result;
	}

	function countNomineesShowYearAwardNew($show_id, $show_year, $award_id) {
		$query = 'SELECT COUNT(*) as total FROM `z_nominations` WHERE `show_id` = '.$show_id.' AND `show_year` = "'.$show_year.'" AND `award_id` = '.$award_id;
		$result = mysqli_query($this->db, $query);
		$data = mysqli_fetch_array($result);
		$count = $data['total'];
		return $count;
	}
	function countWinnersShowYearAwardNew($show_id, $show_year, $award_id) {
		$query = 'SELECT COUNT(*) as total FROM `z_nominations` WHERE `show_id` = '.$show_id.' AND `show_year` = "'.$show_year.'" AND `award_id` = '.$award_id.' AND `status` = "Winner"';
		$result = mysqli_query($this->db, $query);
		$data = mysqli_fetch_array($result);
		$count = $data['total'];
		return $count;
	}

	public function countNomineesInShowYearNew($show_id, $show_year) {
		$query = 'SELECT COUNT(*) as total FROM `z_nominations` WHERE `show_id` = '.$show_id.' AND `show_year` = "'.$show_year.'"';
		$result = mysqli_query($this->db, $query);
		$data = mysqli_fetch_array($result);
		$count = $data['total'];
		return $count;
	}
	public function countWinnersInShowYearNew($show_id, $show_year) {
		$query = 'SELECT COUNT(*) as total FROM `z_nominations` WHERE `show_id` = '.$show_id.' AND `show_year` = "'.$show_year.'" AND `status` = "Winner"';
		$result = mysqli_query($this->db, $query);
		$data = mysqli_fetch_array($result);
		$count = $data['total'];
		return $count;
	}


	// TODO TRANSFER THESE TO APPROPRIATE MODALS
	public function getNominationAllRowsNoNominationIdNoYear($show_id, $award_id) {
		$result = mysqli_query($this->db, 'SELECT * FROM `z_nominations` WHERE `show_id` = '.$show_id.' AND `award_id` = '.$award_id);
		// array_walk_recursive($result, '_clean');
		if($result) {
			return $result;
		}
		return false;
	}
	function getNominationAllRowsNoNominationId($show_id, $show_year, $award_id) {
		$result = mysqli_query($this->db, 'SELECT * FROM `z_nominations` WHERE `show_id` = '.$show_id.' AND `show_year` = "'.$show_year.'" AND `award_id` = '.$award_id);
		// array_walk_recursive($result, '_clean');
		if($result) {
			return $result;
		}
		return false;
	}



}
?>
