<?php
function get_all_tasks() {
	$db = new Database();
	return $db->get_query("SELECT * FROM tasks");
}

function get_task($id) {
	$db = new Database();
	return $db->get_query("SELECT * FROM tasks WHERE id = $id");
}