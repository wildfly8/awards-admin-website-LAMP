<?php

namespace Vonzo\Models;

class Song extends Model {

	function listSongs($awardModel, $awardShowModel, $awardShowYearModel) {
		if (isset($_GET['q'])) {
			$q = securityCheck($this->db, $_GET['q']);
		} else {
			$q = "";
		}

		if (isset($_GET['limit'])) {
			$limit = $_GET['limit'];
		} else {
			$limit = 25;
		}
		$reportNav = "";
		$actual_link = URL_PATH."/admin/songs/";
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
				</tr>
		";

		$totalCount = mysqli_fetch_array(mysqli_query($this->db, 'SELECT COUNT(*) as total FROM `z_nominations` WHERE `song_title` != ""'));
		if ($q == "" && $limit == "all") {
			$query = 'SELECT * FROM `z_nominations` WHERE `song_title` != "" ORDER BY `song_title` ASC';
		} else if ($q == "") {
			$query = 'SELECT * FROM `z_nominations` WHERE `song_title` != "" ORDER BY `song_title` ASC LIMIT '.$limit;
		} else {
			$query = 'SELECT * FROM `z_nominations` WHERE `song_title` LIKE "%'.$q.'%"';
		}
		$rows = mysqli_query($this->db,$query);
		$result = mysqli_num_rows($rows);
		$reportRows = "";
		if ($result > 0) {
			while ($nomRow = mysqli_fetch_array($rows)) {
					$nominations = "";

					$xAward = $awardModel->getAwardById($nomRow['award_id']);
					$xShow = $awardShowModel->getShowById($nomRow['show_id']);
					$xAwardShowYear = $awardShowYearModel->getByShowIdAndYear($nomRow['show_id'], $nomRow['show_year']);

					$nominations .= '<li>
														<b>'.$nomRow['status'].'</b> ';
														$nominations .= '<a href="'.URL_PATH.'/admin/shows/'.$nomRow['show_id'].'/year/'.$xAwardShowYear['id'].'/category/'.$xAward['id'].'/nomination/'.$nomRow['id'].'">'.$xAward['name'].' |  '.$nomRow['show_year'].' '.$xShow['full_name'].'</a>
													 </li>';

					$reportRows .= '<tr bgcolor=white>
														<td>Song</td>
														<td>
															'.$nomRow['song_title'].'
															<br>'.$nominations.'
														</td>
													</tr>';

			}
		}
		$reportRows .= "</table>";

		$report = "";

		$form = '<h4 class="page-title-bold mb-3 mt-0">Songs ('.$totalCount['total'].')</h2><p><form method=get><input type="text" name="q"';
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
