<?php
function record_and_send_contact($data) {
	$db = new db();

	if(!$data['name'] or !$data['email'] or !$data['msg']) {
		return false;
	}

	$data['name'] = f($data['name']);
	$data['msg'] = f($data['msg']);

	$result = $db->create("contact_records", $data);
	return $result;
}