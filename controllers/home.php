<?php
switch($action) {
	case "":
		show_home();
		break;
	case "about":
		show_about();
		break;
	case "contact":
		show_contact();
		break;
	default:
		show_404();
}

function show_home() {
	$data['msg'] = "TinyMVC is a PHP micro framework with MVC router.";

	render("home", $data);
}

function show_about() {
	render("about");
}

function show_contact() {
	render("contact");
}

function show_404() {
	render("404");
}