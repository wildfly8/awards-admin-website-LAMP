<?php

namespace Vonzo\Models;

class People extends Model {

	public function insertNewPerson($full_name, $suffix, $first_name, $middle_name, $last_name, $dob, $dod, $detailed_desc, $internal_notes) {
		$query = $this->db->prepare("INSERT INTO `z_person`
			(`full_name`, `first_name`, `middle_name`, `last_name`, `suffix`, `detailed_desc`, `dob`, `dod`, `internal_notes`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
		$query->bind_param('sssssssss',
			$full_name,
			$first_name,
			$middle_name,
			$last_name,
			$suffix,
			$detailed_desc,
			$dob,
			$dod,
			$internal_notes);
		if (!$query->execute()) {
		 error_log("insertNewPerson Execute failed: (" . $query->errno . ") " . $query->error);
		}
		$new_person_id = $query->insert_id;
		$query->close();
		return $new_person_id;
	}
	public function doesPersonFullNameExist($full_name) {
		if ($full_name != "") {
			$result = mysqli_query($this->db, 'SELECT * FROM `z_person` WHERE `full_name` LIKE "'.$full_name.'"');
			// array_walk_recursive($result, '_clean');
			if($result) {
				return mysqli_fetch_array($result);
			}
		}
		return false;
	}

	public function getUserProfileByid($xPerson, $awardModel, $awardShowModel, $awardShowYearModel) {
		$full_name = $xPerson['full_name'];
		// START nominations
		$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$xPerson['id'].', person_id_array) > 0';
		$nomRows = mysqli_query($this->db,$query);
		$nomResult = mysqli_num_rows($nomRows);
		$nominations = "";
		if ($nomResult > 0) {
			while($nomRow = mysqli_fetch_array($nomRows)) {
				$xAward = $awardModel->getAwardById($nomRow['award_id']);
				$xShow = $awardShowModel->getShowById($nomRow['show_id']);
				$xAwardShowYear = $awardShowYearModel->getByShowIdAndYear($nomRow['show_id'], $nomRow['show_year']);
				$nominations .= '<li>
													<b>'.$nomRow['status'].'</b>
													<a href="'.URL_PATH.'/admin/shows/'.$nomRow['show_id'].'/year/'.$xAwardShowYear['id'].'/category/'.$nomRow['award_id'].'/nomination/'.$nomRow['id'].'">'.$xAward['name'].' |  '.$nomRow['show_year'].' '.$xShow['full_name'].'</a>
												 </li>';
			}
		}
		// END NOMINATIONS

		$artifactImages = "";
		$artifactDocuments = "";

		$query = 'SELECT * FROM `z_media` WHERE `person_id` = ' . $xPerson['id'];
		$mediaRows = mysqli_query($this->db,$query);
		$mediaResult = mysqli_num_rows($mediaRows);
		if ($mediaResult > 0) {
			while($mediaRow = mysqli_fetch_array($mediaRows)) {
				if ($mediaRow['legacy'] == 1) {
					$url = 'http://www.awardsawardsawards.com/assets/artifact/'.$mediaRow['file_path'];
				} else {
					$url = URL_PATH . '/uploads/' . $mediaRow['file_path'];
				}
				if ($mediaRow['type'] == "Image") {
					$artifactImages .= '<a href="'.URL_PATH.'/admin/media/'.$mediaRow['id'].'">
																<img src="'.$url.'" title="'.$mediaRow['title'].'" height="100">
															</a>';
				} else if ($mediaRow['type'] == "Document") {
					$artifactDocuments .= '<a href="'.$url.'" data-nd target="_blank">'.$mediaRow['title'].'</a><br>';
				}
			}
		}

		if ($xPerson['project_id_array'] != "") {
			$projectIdArray = explode(",", $xPerson['project_id_array']);
			for ($i = 0; $i < sizeof($projectIdArray); $i++) {
				$query = 'SELECT * FROM `z_media` WHERE `project_id` = ' . $projectIdArray[$i];
				$mediaRows = mysqli_query($this->db,$query);
				$mediaResult = mysqli_num_rows($mediaRows);
				if ($mediaResult > 0) {
					while($mediaRow = mysqli_fetch_array($mediaRows)) {
						if ($mediaRow['legacy'] == 1) {
							$url = 'http://www.awardsawardsawards.com/assets/artifact/'.$mediaRow['file_path'];
						} else {
							$url = URL_PATH . '/uploads/' . $mediaRow['file_path'];
						}
						if ($mediaRow['type'] == "Image") {
							$artifactImages .= '<a href="'.URL_PATH.'/admin/media/'.$mediaRow['id'].'">
																		<img src="'.$url.'" title="'.$mediaRow['title'].'" height="100">
																	</a>';
						} else if ($mediaRow['type'] == "Document") {
							$artifactDocuments .= '<a href="'.$url.'" data-nd target="_blank">'.$mediaRow['title'].'</a><br>';
						}
					}
				}
			}
		}

		if ($xPerson['studio_id_array'] != "") {
			$studioIdArray = explode(",", $xPerson['studio_id_array']);
			for ($i = 0; $i < sizeof($studioIdArray); $i++) {
				$query = 'SELECT * FROM `z_media` WHERE `studio_id` = ' . $studioIdArray[$i];
				$mediaRows = mysqli_query($this->db,$query);
				$mediaResult = mysqli_num_rows($mediaRows);
				if ($mediaResult > 0) {
					while($mediaRow = mysqli_fetch_array($mediaRows)) {
						if ($mediaRow['legacy'] == 1) {
							$url = 'http://www.awardsawardsawards.com/assets/artifact/'.$mediaRow['file_path'];
						} else {
							$url = URL_PATH . '/uploads/' . $mediaRow['file_path'];
						}
						if ($mediaRow['type'] == "Image") {
							$artifactImages .= '<a href="'.URL_PATH.'/admin/media/'.$mediaRow['id'].'">
																		<img src="'.$url.'" title="'.$mediaRow['title'].'" height="100">
																	</a>';
						} else if ($mediaRow['type'] == "Document") {
							$artifactDocuments .= '<a href="'.$url.'" data-nd target="_blank">'.$mediaRow['title'].'</a><br>';
						}
					}
				}
			}
		}

		$page = '<h6>People<h6>
		<h4 class="page-title-bold mb-3 mt-0">'.$xPerson['full_name'].'</h4>';

		$page .= '<div class="row">';

			$page .= '<div class="col-md-4">';
				$page .= "<div style='padding: 1em; background-color: rgba(0,100,200,0.3);'>
										<p>
											<b>Full Name</b><br>
											<input type=text id='p_full_name' size=30 value='".$xPerson['full_name']."' disabled>
										</p>

										<p>
											<b>Name Suffix</b><br>
											<input type=text id='p_suffix' size=30 value='".$xPerson['suffix']."'>
										</p>

										<p>
											<b>First Name *</b><br>
											<input type=text id='p_first_name' size=30 value='".$xPerson['first_name']."'>
										</p>

										<p>
											<b>Middle Name</b><br>
											<input type=text id='p_middle_name' size=30 value='".$xPerson['middle_name']."'>
										</p>

										<p>
											<b>Last Name *</b><br>
											<input type=text id='p_last_name' size=30 value='".$xPerson['last_name']."'>
										</p>

										<p>
											<b>Date of Birth</b><br>
											<input type=text id='p_dob' size=30 value='".$xPerson['dob']."'>
										</p>

										<p>
											<b>Date of Death</b><br>
											<input type=text id='p_dod' size=30 value='".$xPerson['dod']."'>
										</p>

										<p>
											<b>Detailed Description</b><br>
											<textarea id='p_detailed_desc' size=30>".$xPerson['detailed_desc']."</textarea>
										</p>

										<p>
											<b>Internal Notes</b><br>
											<textarea id='p_internal_notes' size=30>".$xPerson['internal_notes']."</textarea>
										</p>

									<input type='hidden' id='person_id' value='".$xPerson['id']."'>

									<div class='custom-button edit_person_submit' style='margin-left:0'>Update</div>
								</div>";
			$page .= '</div>';

			$page .= '<div class="col-md-4">';
				$page .= '<fieldset style="margin-left:10px;margin-right:10px;"><legend>Nominations</legend>'.$nominations.'</fieldset>';
			$page .= '</div>';

			$page .= '<div class="col-md-4">';
				$page .= '<fieldset style="margin-left:10px;margin-right:10px;"><legend>Media</legend>'.$artifactImages.'</fieldset>';
				$page .= '<fieldset style="margin-top:10px;margin-left:10px;margin-right:10px;"><legend>Documents</legend>'.$artifactDocuments.'</fieldset>';

				$page .= '<fieldset style="margin-top:10px;margin-left:10px;margin-right:10px;">
										<legend>New Media</legend>
										<input type="file" id="fileUpload">
										<img src="'.URL_PATH.'/themes/light/assets/images/loading-spinner.gif" id="image-upload-loader" class="form-loader">
										<div class="attachment-holder">

										</div>

										<p class="mt-3">
											<b>Title</b><br>
											<input type=text id="media_title" size=30>
										</p>
										<p>
											<b>Source</b><br>
											<input type=text id="media_source" size=30>
										</p>
										<p>
											<b>Caption</b><br>
											<textarea id="media_caption" size=30></textarea>
										</p>

										<input type="hidden" id="media_type" value="Person">
										<input type="hidden" id="media_type_id" value="'.$xPerson['id'].'">
										<div class="custom-button new_media_submit" style="margin-left:0">Submit</div>
									</fieldset>';

			$page .= '</div>';

		$page .= '</div>';
		return $page;
	}











	public function listPeople($awardModel, $awardShowModel, $awardShowYearModel) {
		if (isset($_GET['q'])) {
			$q = securityCheck($this->db, $_GET['q']);
		} else {
			$q = "";
		}

		// if (isset($_GET['page'])) {
		// 	$page = $_GET['page'] + 1;
		// 	$offset = PAGINATION * $page ;
		// } else {
		// 	$page = 0;
		// 	$offset = 0;
		// }
		if (isset($_GET['limit'])) {
			$limit = $_GET['limit'];
		} else {
			$limit = 25;
		}
		$reportNav = "";
		$actual_link = URL_PATH."/admin/people/";
		// if ($page > 0) {
	  //   $last = $page - 2;
	  //   $reportNav .= "<a href=$actual_link&page=$last>Last ".PAGINATION." Records</a> |";
	  //   $reportNav .= " <a href=$actual_link&page=$page>Next ".PAGINATION." Records</a>";
	  //  } else if($page == 0) {
	  //   $reportNav .= "<a href=$actual_link&page=$page>Next ".PAGINATION." Records</a>";
	  //  } else if($left_rec < PAGINATION) {
	  //   $last = $page - 2;
	  //   $reportNav .= "<a href=$actual_link&page=$last>Last ".PAGINATION." Records</a>";
	  //  }
		$reportNav = 'Show: <a href="'.$actual_link.'?limit=25" ';
		if ($limit == 25) { $reportNav .= 'class="bold"'; }
		$reportNav .= '>25</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'?limit=50" ';
		if ($limit == 50) { $reportNav .= 'class="bold"'; }
		$reportNav .= '>50</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'?limit=100" ';
		if ($limit == 100) { $reportNav .= 'class="bold"'; }
		$reportNav .= '>100</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'?limit=250" ';
		if ($limit == 250) { $reportNav .= 'class="bold"'; }
		$reportNav .= '>250</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'?limit=1000" ';
		if ($limit == 1000) { $reportNav .= 'class="bold"'; }
		$reportNav .= '>1,000</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'?limit=all" ';
		if ($limit == "all") { $reportNav .= 'class="bold"'; }
		$reportNav .= '>All</a>';

		$reportHeader = "";
		if ($q != "") {
			$reportHeader .= '<h4 class="page-title-bold mb-3 mt-0">Searching <u>'.$q.'</u></h4>';
		}
		$reportHeader .= "
		 <table border='0' cellpadding='5' cellspacing='1' bgcolor='black' width='100%' class='table-bordered'>
				<tr bgcolor=#aaaaaa>
					<td><b>Type</b></td>
					<td><b>Name</b></td>
					<td><b>Noms</b></td>
					<td><b>Wins</b></td>
					<td><b>Images</b></td>
					<td><b>Notes</b></td>
					<td><b>Actions</b></td>
				</tr>
		";

		$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_person`'));

		if ($q == "" && $limit == "all") {
			$query = 'SELECT * FROM `z_person` ORDER BY `full_name` ASC';
		} else if ($q == "") {
			$query = 'SELECT * FROM `z_person` ORDER BY `full_name` ASC LIMIT '.$limit;
		} else {
			$query = 'SELECT * FROM `z_person` WHERE `full_name` LIKE "%'.$q.'%"';
		}
		$rows = mysqli_query($this->db,$query);
		$result = mysqli_num_rows($rows);
		$reportRows = "";
		if ($result > 0) {
			while ($row = mysqli_fetch_array($rows)) {
				if (trim($row['full_name']) != "") {

					$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', person_id_array) > 0';
					$nomRows = mysqli_query($this->db,$query);
					$nomResult = mysqli_num_rows($nomRows);
					$nominations = "";
					if ($nomResult > 0) {
						while($nomRow = mysqli_fetch_array($nomRows)) {

							$xAward = $awardModel->getAwardById($nomRow['award_id']);
							$xShow = $awardShowModel->getShowById($nomRow['show_id']);
							$xAwardShowYear = $awardShowYearModel->getByShowIdAndYear($nomRow['show_id'], $nomRow['show_year']);

							$nominations .= '<li>
																<b>'.$nomRow['status'].'</b>';
																$nominations .= '<a href="'.URL_PATH.'/admin/shows/'.$nomRow['show_id'].'/year/'.$xAwardShowYear['id'].'/category/'.$xAward['id'].'/nomination/'.$nomRow['id'].'">'.$xAward['name'].' |  '.$nomRow['show_year'].' '.$xShow['full_name'].'</a>
															 </li>';
						}
					}

					$person_media_rows =  $this->getMeidaByPersonId($row['id']);
					$person_media_return = "";
					if ($person_media_rows) {
						while ($xPersonMedia = mysqli_fetch_array($person_media_rows)) {
							 $url = "http://www.awardsawardsawards.com/assets/artifact/".$xPersonMedia['file_path'];
								switch ($xPersonMedia['type'])
								{
									case "Image":
										$person_media_return .= '<a href="'.URL_PATH.'/admin/people/'.$row['id'].'"><img src="'.$url.'" height="60"></a>';
										break;
									case "Document":
										$person_media_return .= "<a href=$url target=_blank>View</a>";
										break;
								}
						}
					}

					$queryContent = urlencode(trim($row['full_name']));
					$reportRows .= '<tr bgcolor=white>
														<td>Person</td>
														<td>
															<a href="'.URL_PATH.'/admin/people/'.$row['id'].'">'.$row['full_name'].'</a>
															<br>'.$nominations.'
														</td>
														<td></td>
														<td></td>

														<td>'.$person_media_return.'</td>

														<td></td>
														<td></td>
													</tr>';
				}
			}
		}
		$reportRows .= "</table>";

		$report = "";

		$form = '<h4 class="page-title-bold mb-3 mt-0">People ('.$totalCount['total'].')</h2>
			<p><form method="get"><input type="text" name="q"';
			if ($q != "") { $form .= ' value="'.$q.'"'; }
		$form .= '><input type="submit" value="search"><p>';
		$report .= $form;
		if ($q == "") {
			$report .= "<p>" . $reportNav . "</p>";
		}
		 $report .= "<p>" . $reportHeader . $reportRows . "</p>";

		if ($q == "") {
			$report .= "<p>" . $reportNav . "<br><br><br>";
		}

		return $report;

	}

	public function doesPersonExistById($id) {
		if ($id != "") {
			$result = mysqli_fetch_array(mysqli_query($this->db, 'SELECT * FROM `z_person` WHERE `id` = '.$id));
			// array_walk_recursive($result, '_clean');
			if($result) {
				return $result;
			}
		}
		return false;
	}

	public function getMeidaByPersonId($person_id) {
		$result = mysqli_query($this->db, 'SELECT * FROM `z_media` WHERE `person_id` = "'.$person_id.'"');
		// array_walk_recursive($result, '_clean');
		if($result) {
			return $result;
		}
		return false;
	}

}

?>
