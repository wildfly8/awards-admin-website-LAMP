<?php

namespace Vonzo\Models;

class AwardShow extends Model {

	public function getShowById($show_id) {
		$query = $this->db->prepare("SELECT * FROM `z_award_show` WHERE `id` = ?");
		$query->bind_param('i', $show_id);
		$query->execute();
		$result = $query->get_result()->fetch_assoc();
		$query->close();
		return $result;

	}

	public function getAllAwardShows() {
		$query = $this->db->prepare("SELECT * FROM `z_award_show` ORDER BY `full_name` ASC");
		$query->execute();
		$result = $query->get_result();
		$query->close();
		$data['shows'] = array();
		$i = 0;
		foreach($result as $xShow) {
			$data['shows'][$i]['main'] = $xShow;
			$data['shows'][$i]['ceremony_count'] = $this->getNumberOfYearsForAwardShow($xShow['id']);
			$i++;
		}
		return $data['shows'];
	}

	public function getNumberOfYearsForAwardShow($award_show_id) {
		$query = 'SELECT COUNT(*) as total FROM `z_award_show_year` WHERE `award_show_id` = '.$award_show_id;
		$result = mysqli_query($this->db, $query);
		$data = mysqli_fetch_array($result);
		$count = $data['total'];
		return $count;
	}




}
