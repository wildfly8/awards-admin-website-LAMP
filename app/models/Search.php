<?php

namespace Vonzo\Models;

class Search extends Model {

	public function list($type, $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel, $networkModel, $departmentModel, $awardModel, $awardShowModel, $awardShowYearModel, $songModel) {
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
		$actual_link = URL_PATH.'/admin/'.$type.'/';
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

		if ($type == "people") {
			$singularType = "person";
			$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_person`'));
			if ($q == "" && $limit == "all") {
				$query = 'SELECT * FROM `z_person` ORDER BY `full_name` ASC';
			} else if ($q == "") {
				$query = 'SELECT * FROM `z_person` ORDER BY `full_name` ASC LIMIT '.$limit;
			} else {
				$query = 'SELECT * FROM `z_person` WHERE `full_name` LIKE "%'.$q.'%"';
			}
		} else if ($type == "projects") {
			$singularType = "project";
			$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_project`'));
			if ($q == "" && $limit == "all") {
				$query = 'SELECT * FROM `z_project` ORDER BY `title_name` ASC';
			} else if ($q == "") {
				$query = 'SELECT * FROM `z_project` ORDER BY `title_name` ASC LIMIT '.$limit;
			} else {
				$query = 'SELECT * FROM `z_project` WHERE `title_name` LIKE "%'.$q.'%"';
			}
		} else if ($type == "vendors") {
			$singularType = "vendor";
			$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_vendor`'));
			if ($q == "" && $limit == "all") {
				$query = 'SELECT * FROM `z_vendor` ORDER BY `company_name` ASC';
			} else if ($q == "") {
				$query = 'SELECT * FROM `z_vendor` ORDER BY `company_name` ASC LIMIT '.$limit;
			} else {
				$query = 'SELECT * FROM `z_vendor` WHERE `company_name` LIKE "%'.$q.'%"';
			}
		} else if ($type == "studios") {
			$singularType = "studio";
			$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_studio`'));
			if ($q == "" && $limit == "all") {
				$query = 'SELECT * FROM `z_studio` ORDER BY `company_name` ASC';
			} else if ($q == "") {
				$query = 'SELECT * FROM `z_studio` ORDER BY `company_name` ASC LIMIT '.$limit;
			} else {
				$query = 'SELECT * FROM `z_studio` WHERE `company_name` LIKE "%'.$q.'%"';
			}
		} else if ($type == "products") {
			$singularType = "product";
			$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_product`'));
			if ($q == "" && $limit == "all") {
				$query = 'SELECT * FROM `z_product` ORDER BY `company_name` ASC';
			} else if ($q == "") {
				$query = 'SELECT * FROM `z_product` ORDER BY `company_name` ASC LIMIT '.$limit;
			} else {
				$query = 'SELECT * FROM `z_product` WHERE `company_name` LIKE "%'.$q.'%"';
			}
		} else if ($type == "networks") {
			$singularType = "network";
			$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_network`'));
			if ($q == "" && $limit == "all") {
				$query = 'SELECT * FROM `z_network` ORDER BY `company_name` ASC';
			} else if ($q == "") {
				$query = 'SELECT * FROM `z_network` ORDER BY `company_name` ASC LIMIT '.$limit;
			} else {
				$query = 'SELECT * FROM `z_network` WHERE `company_name` LIKE "%'.$q.'%"';
			}
		} else if ($type == "departments") {
			$singularType = "department";
			$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_department`'));
			if ($q == "" && $limit == "all") {
				$query = 'SELECT * FROM `z_department` ORDER BY `company_name` ASC';
			} else if ($q == "") {
				$query = 'SELECT * FROM `z_department` ORDER BY `company_name` ASC LIMIT '.$limit;
			} else {
				$query = 'SELECT * FROM `z_department` WHERE `company_name` LIKE "%'.$q.'%"';
			}
		}
		$rows = mysqli_query($this->db,$query);
		$result = mysqli_num_rows($rows);
		$reportRows = "";
		if ($result > 0) {
			while ($row = mysqli_fetch_array($rows)) {
				if ($type == "people") {
					$title = trim($row['full_name']);
				} else if ($type == "projects") {
					$title = trim($row['title_name']);
				} else {
					$title = trim($row['company_name']);
				}
				if ($title != "") {

					if ($type == "people") {
						$singularType = "person";
						$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', person_id_array) > 0';
						$person_media_rows =  $peopleModel->getMeidaByPersonId($row['id']);
					} else if ($type == "projects") {
						$singularType = "project";
						$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', project_id_array) > 0';
						$person_media_rows =  $projectModel->getMeidaByProjectId($row['id']);
					} else if ($type == "vendors") {
						$singularType = "vendor";
						$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', vendor_id_array) > 0';
						$person_media_rows =  $vendorModel->getMeidaByVendorId($row['id']);
					} else if ($type == "studios") {
						$singularType = "studio";
						$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', studio_id_array) > 0';
						$person_media_rows =  $studioModel->getMeidaByStudioId($row['id']);
					} else if ($type == "products") {
						$singularType = "product";
						$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', product_id_array) > 0';
						$person_media_rows =  $productModel->getMeidaByProductId($row['id']);
					} else if ($type == "networks") {
						$singularType = "network";
						$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', network_id_array) > 0';
						$person_media_rows =  $networkModel->getMeidaByNetworkId($row['id']);
					} else if ($type == "departments") {
						$singularType = "department";
						$query = 'SELECT * FROM `z_nominations` WHERE FIND_IN_SET('.$row['id'].', department_id_array) > 0';
						$person_media_rows =  $departmentModel->getMeidaByPersonId($row['id']);
					}

					$nomRows = mysqli_query($this->db,$query);
					$nomResult = mysqli_num_rows($nomRows);
					$nominations = "";
					if ($nomResult > 0) {
						while($nomRow = mysqli_fetch_array($nomRows)) {

							$xAward = $awardModel->getAwardById($nomRow['award_id']);
							$xShow = $awardShowModel->getShowById($nomRow['show_id']);
							$xAwardShowYear = $awardShowYearModel->getByShowIdAndYear($nomRow['show_id'], $nomRow['show_year']);

							$nominations .= '<li>';
																$nominations .= '<a href="'.URL_PATH.'/admin/shows/'.$nomRow['show_id'].'/year/'.$xAwardShowYear['id'].'/category/'.$xAward['id'].'/nomination/'.$nomRow['id'].'">'.$xAward['name'].' |  '.$nomRow['show_year'].' '.$xShow['full_name'].'</a>
																 <b>'.$nomRow['status'].'</b>
															 </li>';
						}
					}

					$person_media_return = "";
					if ($person_media_rows) {
						while ($xPersonMedia = mysqli_fetch_array($person_media_rows)) {
							 if ($xPersonMedia['legacy'] == 1) {
								 $url = 'http://www.awardsawardsawards.com/assets/artifact/'.$xPersonMedia['file_path'];
							 } else {
								 $url = URL_PATH . '/uploads/' . $xPersonMedia['file_path'];
							 }
								switch ($xPersonMedia['type'])
								{
									case "Image":
										$person_media_return .= '<a href="'.URL_PATH.'/admin/'.$type.'/'.$row['id'].'"><img src="'.$url.'" height="60"></a>';
										break;
									case "Document":
										$person_media_return .= '<a href="'.$url.'" data-nd target="_blank">View Document</a>';
										break;
								}
						}
					}

					$reportRows .= '<tr bgcolor=white>
														<td>'.ucfirst($type).'</td>
														<td>
															<a href="'.URL_PATH.'/admin/'.$type.'/'.$row['id'].'">'.$title.'</a>
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

		$form = '<h4 class="page-title-bold mb-3 mt-0 inline">'.ucfirst($type).' ('.$totalCount['total'].')</h2> <a href="'.URL_PATH.'/admin/add/'.$singularType.'" class="custom-button inline">Add '.ucfirst($singularType).'</a>
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

}

?>
