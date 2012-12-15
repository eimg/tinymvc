<?php
function f($str, $strip=false) {
	if($strip) {
		return htmlspecialchars(strip_tags($str), ENT_QUOTES, 'UTF-8', false);
	}

	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8', false);
}