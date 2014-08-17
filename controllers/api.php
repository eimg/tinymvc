<?php
# http_auth();

function index() {
	//respond(array("msg"=>"Welcome!"));
	template("index.php");
}

function hello() {
	respond(array("msg"=>"Hello, World!"));
}

function bye() {
	respond(array("msg"=>"Good Bye!"));
}