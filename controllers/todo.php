<?php
$METHOD = $_SERVER['REQUEST_METHOD'];

if($METHOD == "GET"):

	# Mapping GET actions
	if($action == "tasks") {
		all_tasks();
	} elseif($action == "task") {
		a_task($id);
	} else {
		invalid_request_error();
	}

endif;

if($METHOD == "POST"):
	# Map POST actions here
endif;

if($METHOD == "PUT"):
	# Map PUT actions here
endif;

if($METHOD == "DELETE"):
	# Map DELETE actions here
endif;

# Functions
function all_tasks() {
	$tasks = get_all_tasks();
	
	if(count($tasks)) {
		echo json_encode($tasks);
	} else {
		echo json_encode(array(
			"empty" => 1,
			"msg" => "Empty result! There is no task due."
		));
	}
}

function a_task($id) {
	$task = get_task($id);
	
	if($task) {
		echo json_encode($task);
	} else {
		echo json_encode(array(
			"empty" => 1,
			"msg" => "The task you try to get doesn't exists."
		));
	}
}

function invalid_request_error($value='') {
	echo json_encode(array(
		"err" => 1,
		"msg" => "Invalid request!"
	));
}