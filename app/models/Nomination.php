<?php

namespace Vonzo\Models;

class Nomination extends Model {

	public function getNominationPage($productModel, $networkModel, $personModel, $projectModel, $vendorModel, $studioModel, $xAward, $xAwardShow, $nomination_id, $show_id, $show_year_id, $show_year) {

		$xNomGet = $this->getNominationById($nomination_id);
		$award_id = $xNomGet['award_id'];
		$award_year = $xNomGet['award_year'];
		$recap = "";

		$xNomRows = $this->getNominationAllRows($show_id, $show_year, $award_id, $award_year);
		while($xNom = mysqli_fetch_array($xNomRows)) {
			$projectIdArray = explode(",", $xNom['project_id_array']);
			$personIdArray = explode(",", $xNom['person_id_array']);
			$studioIdArray = explode(",", $xNom['studio_id_array']);
			$vendorIdArray = explode(",", $xNom['vendor_id_array']);

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
			$recap .= "<li> $person <b>$project</b> $vendor $studio";
			$recap .= ' | <a href="'.URL_PATH.'/admin/shows/'.$show_id.'/year/'.$show_year_id.'/category/'.$award_id.'/nomination/'.$xNom['id'].'">Edit</a> <span class="bold" style="text-decoration:none;">'.$xNom['status'].'</span>';
		} // end top while loop


		// Prepare the winner toggle
		$page = "<h6>Nomination $nomination_id</h6>";

		$page .= '<h4 class="page-title-bold mb-3 mt-0">Nominated at the <a href="'.URL_PATH.'/admin/shows/'.$show_id.'/year/'.$show_year_id.'">'.$show_year . ' ' . $xAwardShow['full_name'].'</a> for '.$xAward['name'].'</h4>';

		// <h1>Nominated at the <a href=spreadsheet.php?show=$show_id&year=$show_year>$show_year ".$xAwardShow['full_name']."</a> for ".$xAward['name']."</h1>
		$page .= "
		<fieldset>
		<legend>Nominees for ".$xAward['name']." at the $show_year ".$xAwardShow['full_name']."</legend>
		$recap
		</fieldset>";


		///////////////
		// FORMS
		$xNomination = $this->getNominationById($nomination_id);
		$page .= "<p><fieldset style='background-color: rgba(0,100,200,0.3)'>
		<legend>Update information for this nomination $nomination_id</legend>";

		if ($xNomination['status'] == "Winner") {
			$page .= "<p><B>Winner</B></p>";
		} else {
			$page .= "<p><i>NOT Winner</i></p>";
		}

		$page .= "<p>Project Title:<br>";
			$project_array = explode(",", $xNomination['project_id_array']);
			for ($i = 0; $i < sizeof($project_array); $i++) {
				$xProject = $projectModel->doesProjectExistById($project_array[$i]);
				$page .= '<p><input type="text" name="content" value="'.$xProject['title_name'].'" size="50"><p>';
			}
			if ($xNomination['project_tv_id'] != 0) {
				$xProjectTv = $projectModel->getProjectTvByProjectId($xNomination['project_tv_id']);
				if ($xProjectTv) {
					$page .= "
					<fieldset>
					<legend>DO NOT ENTER ANY QUOTES OR PARENTHESES OR MARIJUANA !</legend>
					<p>Season Number: <input type='text' name='content' value='".$xProjectTv['season']."' size='50'></p>
					<p>Episode Number: <input type='text' name='content' value='".$xProjectTv['episode']."' size='50'></p>
					<p>Episode Title (for Television of Commercial project): <input type='text' name='content' value='".$xProjectTv['episode_title']."' size='50'></p>
					</fieldset>";
				} else {
					$page .= "
					<fieldset>
					<legend>DO NOT ENTER ANY QUOTES OR PARENTHESES OR MARIJUANA !</legend>
					<p>Episode Number: <input type='text' name='content' value='' size='50'></p>
					<p>Episode Number: <input type='text' name='content' value='' size='50'></p>
					<p>Episode Title (for Television of Commercial project): <input type='text' name='content' value='' size='50'></p>
					</fieldset>";
				}
			} else {
				$page .= "
				<fieldset>
				<legend>DO NOT ENTER ANY QUOTES OR PARENTHESES OR MARIJUANA !</legend>
				<p>Episode Number: <input type='text' name='content' value='' size='50'></p>
				<p>Episode Number: <input type='text' name='content' value='' size='50'></p>
				<p>Episode Title (for Television of Commercial project): <input type='text' name='content' value='' size='50'></p>
				</fieldset>";
			}

		$page .= "</p><p>People:<BR>";
		$person_array = explode(",", $xNomination['person_id_array']);
		for ($i = 0; $i < sizeof($person_array); $i++) {
			$xPerson = $personModel->doesPersonExistById($person_array[$i]);
			if ($xPerson) {
				$xNomToPersonRole = $this->getNomToRolePerson($xNomination['id'], $person_array[$i]);
				$page .= '<p><input type="text" name="content" value="'.$xPerson['full_name'].'" size="50">';
				if ($xNomToPersonRole) {
					$page .= " " . $xNomToPersonRole['role'];
				}
				$page .= "</p>";
			}
		}

		$page .= "</p><p>Studio:<BR>";
		$studio_array = explode(",", $xNomination['studio_id_array']);
		for ($i = 0; $i < sizeof($studio_array); $i++) {
			$xStudio = $studioModel->doesStudioExistById($studio_array[$i]);
			$page .= '<p><input type="text" name="content" value="'.$xStudio['company_name'].'" size="50"><p>';
		}

		$page .= "</p><p>Vendor:<BR>";
		$vendor_array = explode(",", $xNomination['vendor_id_array']);
		for ($i = 0; $i < sizeof($vendor_array); $i++) {
			$xVendor = $vendorModel->doesVendorExistById($vendor_array[$i]);
			$page .= '<p><input type="text" name="content" value="'.$xVendor['company_name'].'" size="50"></p>';
		}

		$page .= "</p><p>Product:<BR>";
		$product_array = explode(",", $xNomination['product_id_array']);
		for ($i = 0; $i < sizeof($product_array); $i++) {
			$xProduct = $productModel->doesProductExistById($product_array[$i]);
			$page .= '<p><input type="text" name="content" value="'.$xProduct['company_name'].'" size="50"></p>';
		}

		$page .= "</p><p>Network:<BR>";
		$network_array = explode(",", $xNomination['network_id_array']);
		for ($i = 0; $i < sizeof($network_array); $i++) {
			$xNetwork = $networkModel->doesNetworkExistById($network_array[$i]);
			$page .= '<p><input type="text" name="content" value="'.$xNetwork['company_name'].'" size="50"></p>';
		}

		$page .= "</p><p>Song Title:<BR>";
		$page .= '<p><input type="text" name="content" value="'.$xNomination['song_title'].'" size="50"></p>';

		$page .= "</p><p>Bit:<BR>";
		$page .= '<p><input type="text" name="content" value="'.$xNomination['bit'].'" size="50"></p>';


		$page .= "</p><p>Legacy Notes:<BR>";
		$page .= '<p>'.$xNomination['legacy_notes'].'</p>';
		$page .= "</p> <BR><BR>";

		return $page;

	} // end get Nomination Page

	public function getNomToRolePerson($nomination_id, $person_id) {
		$result = mysqli_fetch_array(mysqli_query($this->db, 'SELECT * FROM `z_nom_to_person_role` WHERE `nom_id` = '.$nomination_id.' AND `person_id` = '.$person_id));
		// array_walk_recursive($result, '_clean');
		if($result) {
			return $result;
		}
		return false;
	}

	public function getNominationAllRows($show_id, $show_year, $award_id, $award_year) {
		$result = mysqli_query($this->db, 'SELECT * FROM `z_nominations` WHERE `show_id` = '.$show_id.' AND `show_year` = "'.$show_year.'" AND `award_id` = '.$award_id.' AND `award_year` = '.$award_year);
		// array_walk_recursive($result, '_clean');
		if($result) {
			return $result;
		}
		return false;

	}

	public function getNominationById($nomination_id) {
		$result = mysqli_fetch_array(mysqli_query($this->db, 'SELECT * FROM `z_nominations` WHERE `id` = '.$nomination_id));
		// array_walk_recursive($result, '_clean');
		if($result) {
			return $result;
		}
		return false;

	}


}
