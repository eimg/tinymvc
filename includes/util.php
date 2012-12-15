<?php
function truncate($str, $crop, $trail='...') {
	mb_internal_encoding('UTF-8');

	if(strlen($str) <= $crop or $crop < 1) {
		return $str;
	} else {
		$str = mb_substr($str, 0, ($crop - (count($trail)+1)));
		return $str . " " . $trail;
	}
}