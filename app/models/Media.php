<?php

namespace Vonzo\Models;

class Media extends Model {

	public function insertNewMedia($media_type, $media_type_id, $media_title, $media_source, $media_caption, $attachments) {
		$attachmentArray = explode(",", $attachments);

		for ($i = 0; $i < sizeof($attachmentArray); $i++) {
			$file = $attachmentArray[$i];

			if (strpos(strtolower($file), 'pdf') !== false) {
				$type = "Document";
			} else {
				$type = "Image";
			}

			$legacy = 0;
			if ($media_type == "Person") {
				$query = $this->db->prepare("INSERT INTO `z_media`
				(`type`, `person_id`, `main_content`, `title`, `file_path`, `source`, `legacy`)
				VALUES (?, ?, ?, ?, ?, ?, ?);");
				$query->bind_param('sissssi',
					$type,
					$media_type_id,
					$media_caption,
					$media_title,
					$file,
					$media_source,
					$legacy);
				if (!$query->execute()) {
				 error_log("insertNewMedia insert Execute failed: (" . $query->errno . ") " . $query->error);
			  }
				$query->close();
			} else if ($media_type == "Project") {
				$query = $this->db->prepare("INSERT INTO `z_media`
				(`type`, `project_id`, `main_content`, `title`, `file_path`, `source`, `legacy`)
				VALUES (?, ?, ?, ?, ?, ?, ?);");
				$query->bind_param('sissssi',
					$type,
					$media_type_id,
					$media_caption,
					$media_title,
					$file,
					$media_source,
					$legacy);
				if (!$query->execute()) {
				 error_log("insertNewMedia insert Execute failed: (" . $query->errno . ") " . $query->error);
				}
				$query->close();
			} else if ($media_type == "Studio") {
				$query = $this->db->prepare("INSERT INTO `z_media`
				(`type`, `studio_id`, `main_content`, `title`, `file_path`, `source`, `legacy`)
				VALUES (?, ?, ?, ?, ?, ?, ?);");
				$query->bind_param('sissssi',
					$type,
					$media_type_id,
					$media_caption,
					$media_title,
					$file,
					$media_source,
					$legacy);
				if (!$query->execute()) {
				 error_log("insertNewMedia insert Execute failed: (" . $query->errno . ") " . $query->error);
				}
				$query->close();
			} else if ($media_type == "Vendor") {
				$query = $this->db->prepare("INSERT INTO `z_media`
				(`type`, `vendor_id`, `main_content`, `title`, `file_path`, `source`, `legacy`)
				VALUES (?, ?, ?, ?, ?, ?, ?);");
				$query->bind_param('sissssi',
					$type,
					$media_type_id,
					$media_caption,
					$media_title,
					$file,
					$media_source,
					$legacy);
				if (!$query->execute()) {
				 error_log("insertNewMedia insert Execute failed: (" . $query->errno . ") " . $query->error);
				}
				$query->close();
			} else if ($media_type == "Product") {
				$query = $this->db->prepare("INSERT INTO `z_media`
				(`type`, `product_id`, `main_content`, `title`, `file_path`, `source`, `legacy`)
				VALUES (?, ?, ?, ?, ?, ?, ?);");
				$query->bind_param('sissssi',
					$type,
					$media_type_id,
					$media_caption,
					$media_title,
					$file,
					$media_source,
					$legacy);
				if (!$query->execute()) {
				 error_log("insertNewMedia insert Execute failed: (" . $query->errno . ") " . $query->error);
				}
				$query->close();
			} else if ($media_type == "Network") {
				$query = $this->db->prepare("INSERT INTO `z_media`
				(`type`, `network_id`, `main_content`, `title`, `file_path`, `source`, `legacy`)
				VALUES (?, ?, ?, ?, ?, ?, ?);");
				$query->bind_param('sissssi',
					$type,
					$media_type_id,
					$media_caption,
					$media_title,
					$file,
					$media_source,
					$legacy);
				if (!$query->execute()) {
				 error_log("insertNewMedia insert Execute failed: (" . $query->errno . ") " . $query->error);
				}
				$query->close();
			}

		} // end for loop



	} // end insertNewMedia

	function listMedia($awardModel, $awardShowModel, $awardShowYearModel, $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel) {
		if (isset($_GET['q'])) {
			$q = securityCheck($this->db, $_GET['q']);
		} else {
			$q = "";
		}
		if (isset($_GET['mediaType'])) {
			$mediaType = securityCheck($this->db, $_GET['mediaType']);
		} else {
			$mediaType = "";
		}

			if (isset($_GET['page'])) {
				$page = $_GET['page'] + 1;
				$offset = PAGINATION * $page ;
			} else {
				$page = 0;
				$offset = 0;
			}
			$reportNav = "";
			$actual_link = URL_PATH."/admin/media/";
			if ($page > 0) {
		    $last = $page - 2;
		    $reportNav .= "<a href=$actual_link?page=$last>Last ".PAGINATION." Records</a> |";
		    $reportNav .= " <a href=$actual_link?page=$page>Next ".PAGINATION." Records</a>";
		   } else if($page == 0) {
		    $reportNav .= "<a href=$actual_link?page=$page>Next ".PAGINATION." Records</a>";
		   } else if($left_rec < PAGINATION) {
		    $last = $page - 2;
		    $reportNav .= "<a href=$actual_link?page=$last>Last ".PAGINATION." Records</a>";
		   }

			$reportHeader = "";
			if ($q != "") {
				$reportHeader .= '<h4 class="page-title-bold mb-3 mt-0">Searching <u>'.$q.'</u></h4>';
			}
			$reportHeader = "
				<table border='0' cellpadding='5' cellspacing='1' bgcolor='black' width='100%' class='table-bordered'>
					<tr bgcolor=#aaaaaa>
						<td><b>Type</b></td>
						<td><b>File</b></td>
						<td><b>Details</b></td>
						<td><b>Notes</b></td>
						<td><b>Actions</b></td>
					</tr>
			";

			$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_media`'));

			$query = 'SELECT * FROM `z_media`';
			if ($q != "") {
				if ($mediaType == "") {
					$query .= ' WHERE `main_content` LIKE "%'.$q.'%" OR `title` LIKE "%'.$q.'%"';
				} else {
					$query .= ' WHERE (`main_content` LIKE "%'.$q.'%" OR `title` LIKE "%'.$q.'%")';
				}
			}
			if ($mediaType != "") {
				if ($q != "") {
					$query .= ' AND `type` = "'.$mediaType.'"';
				} else {
					$query .= ' WHERE `type` = "'.$mediaType.'"';
				}
			}

			if ($q == "") {
				$query .= ' LIMIT '.$offset.', '.PAGINATION;
			}
			$rows = mysqli_query($this->db,$query);
			$result = mysqli_num_rows($rows);
			$reportRows = "";
			if ($result > 0) {
				while ($row = mysqli_fetch_array($rows)) {

					if ($row['legacy'] == 1) {
						$url = 'http://www.awardsawardsawards.com/assets/artifact/'.$row['file_path'];
					} else {
						$url = URL_PATH . '/uploads/' . $row['file_path'];
					}

						if ($row['person_id'] != 0) {
							$xPeople = $peopleModel->doesPersonExistById($row['person_id']);
							$thumbnail = $this->getThumbnail("people", $row, $xPeople['id']);
							$connectionsPeople = '<a href="'.URL_PATH.'/admin/people/'.$xPeople['id'].'">'. $xPeople['full_name'] . '</a>';
							if ($row['type'] == "Image") {
								$thumbnail = '<a href="'.URL_PATH.'/admin/people/'.$xPeople['id'].'"><img src="'.$url.'" height="100"></a>';
							} else if ($row['type'] == "Document") {
								$thumbnail = '<a href="'.$url.'" data-nd target="_blank">View Document</a>';
							}
						} else {
							$connectionsPeople = "";
						}

						if ($row['project_id'] != 0) {
							$xProject = $projectModel->doesProjectExistById($row['project_id']);
							$thumbnail = $this->getThumbnail("projects", $row, $xProject['id']);
							$connectionsProjects = '<a href="'.URL_PATH.'/admin/projects/'.$xProject['id'].'">'. $xProject['title_name'] . '</a>';
							if ($row['type'] == "Image") {
								$thumbnail = '<a href="'.URL_PATH.'/admin/projects/'.$xProject['id'].'"><img src="'.$url.'" height="100"></a>';
							} else if ($row['type'] == "Document") {
								$thumbnail = '<a href="'.$url.'" data-nd target="_blank">View Document</a>';
							}
						} else {
							$connectionsProjects = "";
						}

						if ($row['studio_id'] != 0) {
						 	$xStudio = $studioModel->doesStudioExistById($row['studio_id']);
							$thumbnail = $this->getThumbnail("studios", $row, $xStudio['id']);
							$connectionsStudios = '<a href="'.URL_PATH.'/admin/studios/'.$xStudio['id'].'">'.	$xStudio['company_name'] . '</a>';
							if ($row['type'] == "Image") {
								$thumbnail = '<a href="'.URL_PATH.'/admin/studios/'.$xStudio['id'].'"><img src="'.$url.'" height="100"></a>';
							} else if ($row['type'] == "Document") {
								$thumbnail = '<a href="'.$url.'" data-nd target="_blank">View Document</a>';
							}
						} else {
							$connectionsStudios = "";
						}
						if ($row['vendor_id'] != 0) {
							$xVendor = $vendorModel->doesVendorExistById($row['vendor_id']);
							$thumbnail = $this->getThumbnail("vendors", $row, $xVendor['id']);
							$connectedVendors = '<a href="'.URL_PATH.'/admin/vendors/'.$xVendor['id'].'">'.	$xVendor['company_name'] . '</a>';
							if ($row['type'] == "Image") {
								$thumbnail = '<a href="'.URL_PATH.'/admin/vendors/'.$xVendor['id'].'"><img src="'.$url.'" height="100"></a>';
							} else if ($row['type'] == "Document") {
								$thumbnail = '<a href="'.$url.'" data-nd target="_blank">View Document</a>';
							}
						} else {
							$connectedVendors = "";
						}
						if ($row['product_id'] != 0) {
							$xProduct = $productModel->doesProductExistById($row['product_id']);
							$thumbnail = $this->getThumbnail("products", $row, $xProduct['id']);
							$connectedProducts = '<a href="'.URL_PATH.'/admin/products/'.$xProduct['id'].'">'.	$xProduct['company_name'] . '</a>';
							if ($row['type'] == "Image") {
								$thumbnail = '<a href="'.URL_PATH.'/admin/products/'.$xProduct['id'].'"><img src="'.$url.'" height="100"></a>';
							} else if ($row['type'] == "Document") {
								$thumbnail = '<a href="'.$url.'" data-nd target="_blank">View Document</a>';
							}
						} else {
							$connectedProducts = "";
						}

						$reportRows 	.= "<tr bgcolor=white>
																<td>".$row['type']."</td>
																<td>$thumbnail</td>
																<td>$connectionsPeople $connectionsProjects $connectionsStudios $connectedVendors $connectedProducts</a></td>
																<td>Uploaded ".$row['created']."</td>
																<td></td>
															</tr>";
				}
			}
			$reportRows .= "</table>";

			$report = "";

			$form = '<h4 class="page-title-bold mb-3 mt-0">Media ('.$totalCount['total'].')</h2><p><form method=get>';
			$form .= '<input type="text" name="q"'; if ($q != "") { $form .= 'value="'.$q.'"'; }$form .= '>';
			$form .= '<select name="mediaType"><option value="">All</option><option value="Image" ';
								if ($mediaType == "Image") { $form .= 'selected'; } $form .= '>Image</option>
								<option value="Document" '; if ($mediaType == "Document") { $form .= 'selected'; } $form .= '>Document</option></select><input type=submit value=search></p>';
								// $form .= $query;
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

	public function getMediaById($media_id) {
		$query = $this->db->prepare("SELECT * FROM `z_media` WHERE `id` = ?");
		$query->bind_param('i', $media_id);
		$query->execute();
		$result = $query->get_result()->fetch_assoc();
		$query->close();
		return $result;
	}

	public function getThumbnail ($type, $row, $id) {
		if ($row['legacy'] == 1) {
			$url = 'http://www.awardsawardsawards.com/assets/artifact/'.$row['file_path'];
		} else {
			$url = URL_PATH . '/uploads/' . $row['file_path'];
		}
		switch ($row['type'])
		{
			case "Image":
				$thumbnail = '<a href="'.URL_PATH.'/admin/'.$type.'/'.$id.'"><img src="'.$url.'" height="100"></a>';
				break;
			case "Document":
				$thumbnail = "<a href=$url target=_blank>View</a>";
				break;
		}
	}

}
