<?php

namespace Vonzo\Models;

class Studio extends Model {

	public function insertNewStudio($studio_name) {
		$query = $this->db->prepare("INSERT INTO `z_studio` (`company_name`) VALUES (?);");
		$query->bind_param('s', $studio_name);
		if (!$query->execute()) {
		 error_log("insertNewStudio Execute failed: (" . $query->errno . ") " . $query->error);
		}
		$new_studio_id = $query->insert_id;
		$query->close();
		return $new_studio_id;
	}
	public function doesStudioNameExist($studio_name) {
		if ($studio_name != "") {
			$result = mysqli_query($this->db, 'SELECT * FROM `z_studio` WHERE `company_name` LIKE "'.$studio_name.'"');
			// array_walk_recursive($result, '_clean');
			if($result) {
				return mysqli_fetch_array($result);
			}
		}
		return false;
	}

	function getStudioProfileById($xStudio, $awardModel, $awardShowModel, $awardShowYearModel) {
		// START nominations
		$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$xStudio['id'].', studio_id_array) > 0';
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

		$query = 'SELECT * FROM `z_media` WHERE `studio_id` = ' . $xStudio['id'];
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

		if ($xStudio['person_id_array'] != "") {
			$projectIdArray = explode(",", $xStudio['person_id_array']);
			for ($i = 0; $i < sizeof($projectIdArray); $i++) {
				$query = 'SELECT * FROM `z_media` WHERE `person_id` = ' . $projectIdArray[$i];
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

		if ($xStudio['project_id_array'] != "") {
			$projectIdArray = explode(",", $xStudio['project_id_array']);
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

		if ($xStudio['vendor_id_array'] != "") {
			$studioIdArray = explode(",", $xStudio['vendor_id_array']);
			for ($i = 0; $i < sizeof($studioIdArray); $i++) {
				$query = 'SELECT * FROM `z_media` WHERE `vendor_id` = ' . $studioIdArray[$i];
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

		$page = '<h6>Studio<h6>
		<h4 class="page-title-bold mb-3 mt-0">'.$xStudio['company_name'].'</h4>';

		$page .= '<div class="row">';

			$page .= '<div class="col-md-4">';
				$page .= "<div style='padding: 1em; background-color: rgba(0,100,200,0.3);'>
										<p>
											<b>Studio Name</b><br>
											<input type=text id='p_company_name' size=30 value='".$xStudio['company_name']."' disabled>
										</p>

									<input type='hidden' id='project_id' value='".$xStudio['id']."'>

									<div class='custom-button edit_project_submit' style='margin-left:0'>Update</div>
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

										<input type="hidden" id="media_type" value="Studio">
										<input type="hidden" id="media_type_id" value="'.$xStudio['id'].'">
										<div class="custom-button new_media_submit" style="margin-left:0">Submit</div>
									</fieldset>';

			$page .= '</div>';

		$page .= '</div>';
		return $page;
	}






	function listStudios($search, $awardModel, $awardShowModel) {

		if ($search != "") {
			// $q = securityCheck($this->db, $_POST['searchKey']);
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
		$actual_link = URL_PATH."/a/index.php?view=studios";
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
		$reportNav = 'Show: <a href="'.$actual_link.'&limit=25" ';
		if ($limit == 25) { $reportNav .= 'style="font-weight:bold;"'; }
		$reportNav .= '>25</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'&limit=50" ';
		if ($limit == 50) { $reportNav .= 'style="font-weight:bold;"'; }
		$reportNav .= '>50</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'&limit=100" ';
		if ($limit == 100) { $reportNav .= 'style="font-weight:bold;"'; }
		$reportNav .= '>100</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'&limit=250" ';
		if ($limit == 250) { $reportNav .= 'style="font-weight:bold;"'; }
		$reportNav .= '>250</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'&limit=1000" ';
		if ($limit == 1000) { $reportNav .= 'style="font-weight:bold;"'; }
		$reportNav .= '>1,000</a> | ';

		$reportNav .= 'Show: <a href="'.$actual_link.'&limit=all" ';
		if ($limit == "all") { $reportNav .= 'style="font-weight:bold;"'; }
		$reportNav .= '>All</a>';

		$reportHeader = "";
		if ($q != "") {
			$reportHeader .= "<h3>Searching <u>".$q."</u></h3>";
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

		$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_studio`'));

		if ($q == "" && $limit == "all") {
			$query = 'SELECT * FROM `z_studio` ORDER BY `company_name` ASC';
		} else if ($q == "") {
			$query = 'SELECT * FROM `z_studio` ORDER BY `company_name` ASC LIMIT '.$limit;
		} else {
			$query = 'SELECT * FROM `z_studio` WHERE `company_name` LIKE "%'.$q.'%"';
		}
		$rows = mysqli_query($this->db,$query);
		$result = mysqli_num_rows($rows);
		$reportRows = "";
		if ($result > 0) {
			while ($row = mysqli_fetch_array($rows)) {
				if (trim($row['company_name']) != "") {

					$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', studio_id_array) > 0';
					$nomRows = mysqli_query($this->db,$query);
					$nomResult = mysqli_num_rows($nomRows);
					$nominations = "";
					if ($nomResult > 0) {
						while($nomRow = mysqli_fetch_array($nomRows)) {

							$xAward = $awardModel->getAwardById($nomRow['award_id']);
							$xShow = $awardShowModel->getShowById($nomRow['show_id']);

							$nominations .= '<li>
																<b>'.$nomRow['status'].'</b> <a href="'.URL_PATH.'/a/index.php?view=nomination&id='.$nomRow['id'].'&show='.$nomRow['show_id'].'&year='.$nomRow['show_year'].'">'.$xAward['name'].' |  '.$nomRow['show_year'].' '.$xShow['full_name'].'</a>
															 </li>';
						}
					}

					$studio_media_rows = $this->getMeidaByStudioId($row['id']);
					$studio_media_return = "";
					if ($studio_media_rows) {
						while ($xStudioMedia = mysqli_fetch_array($studio_media_rows)) {
							 $url = "http://www.awardsawardsawards.com/assets/artifact/".$xStudioMedia['file_path'];
								switch ($xStudioMedia['type'])
								{
									case "Image":
										$studio_media_return .= "<a href=?view=artifacts&id=".$xStudioMedia['id']."><img src=$url height=60></a>";
										break;
									case "Document":
										$studio_media_return .= "<a href=$url target=_blank>View</a>";
										break;
								}
						}
					}

					// $queryContent = urlencode(trim($row['company_name']));
					$reportRows .= '<tr bgcolor=white>
														<td>Studio</td>
														<td>
															<a href="?view=studios&id='.$row['id'].'">'.$row['company_name'].'</a>
															<br>'.$nominations.'
														</td>
														<td></td>
														<td></td>
														<td>'.$studio_media_return.'</td>
														<td></td>
														<td></td>
													</tr>';
				}
			}
		}
		$reportRows .= "</table>";

		$report = "";

		$form = '<h4 class="page-title-bold mb-3 mt-0">Studios ('.$totalCount['total'].')</h2><p><form method=post><input type=hidden name=action value=searchType><input type=hidden name=type value=Studio><input type=text name=searchKey><input type=submit name=submit value=search><p>';
		$report .= $form;
		if ($q == "") {
			$report .= "<p>" . $reportNav . "</p>";
		}
		 $report .= "<p>" . $reportHeader . $reportRows . "</p>";

		if ($q == "") {
			$report .= "<p>" . $reportNav . "<br><br><br>";
		}

		return $report;

	} // end listStudios

	public function doesStudioExistById($id) {
		if ($id != "") {
			$result = mysqli_fetch_array(mysqli_query($this->db, 'SELECT * FROM `z_studio` WHERE `id` = '.$id));
			// array_walk_recursive($result, '_clean');
			if($result) {
				return $result;
			}
		}
		return false;
	}

	public function getMeidaByStudioId($studio_id) {
	  $result = mysqli_query($this->db, 'SELECT * FROM `z_media` WHERE `studio_id` = "'.$studio_id.'"');
	  // array_walk_recursive($result, '_clean');
	  if($result) {
	    return $result;
	  }
	  return false;
	}

}
