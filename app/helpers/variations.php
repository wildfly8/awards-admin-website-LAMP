<?php

function possible_combos($groups, $prefix='') {
		$result = array();
		$group = array_shift($groups);
		foreach($group as $selected) {
				if($groups) {
						$result = array_merge($result, possible_combos($groups, $prefix . $selected. ','));
				} else {
						$result[] = $prefix . $selected;
				}
		}
		return $result;
}

?>
