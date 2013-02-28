<?php
switch($action) {
	case "":
	case "send-success":
		show_home();
		break;
	case "about":
	case "readme":
		show_readme();
		break;
	case "contact":
	case "send-error":
		show_contact();
		break;
	case "license":
		show_license();
		break;
	case "send":
		send_contact();
		break;
	default:
		show_404();
}

function show_home() {
	$data['msg'] = "TinyMVC is a PHP micro framework with MVC router.";

	render("home", $data);
}

function show_contact() {
	render("contact");
}

function show_readme() {
	render("readme");
}

function show_license() {
	render("license");
}

function send_contact() {
	$result = record_and_send_contact($_POST);

	if($result) {
		redirect("home/send-success");
	} else {
		redirect("home/send-error");
	}
}

function show_404() {
	render("404");
}