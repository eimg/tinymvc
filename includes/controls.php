<?php
function include_js($file) {
	global $config;

	if(preg_match("/^https?:\/\//", $file))
		return "<script src='{$file}'></script>\n";

	return "<script src='{$config['path']}/template/js/{$file}'></script>\n";
}

function include_css($file) {
	global $config;

	if(preg_match("/^https?:\/\//", $file))
		return "<link rel='stylesheet' href='{$file}' />";

	return "<link rel='stylesheet' href='{$config['path']}/template/css/{$file}' />";
}

function link_to($url, $text, $title='', $id='', $class='', $attrs='') {
	global $config;

	if(!$text) $text = $url;

	if(preg_match("/^https?:\/\//", $url))
		return "<a href='$url' title='$title' id='$id' class='$class' $attrs>$text</a>";

	return "<a href='{$config['path']}/{$url}' title='$title' id='$id' class='$class' $attrs>$text</a>";
}

function image($url, $alt='', $id='', $class='', $attrs='') {
	global $config;

	if(preg_match("/^https?:\/\//", $url))
		return "<img src='$url' alt='$alt' id='$id' class='$class' $attrs>";

	return "<img src='{$config['path']}/{$url}' alt='$alt' id='$id' class='$class' $attrs>";
}

function form($action, $method='post', $attrs='') {
	global $config;

	if(preg_match("/^https?:\/\//", $url))
		return "<form action='$action' mehtod='$method' $attrs>";

	return "<form action='{$config['path']}/{$action}' method='$method' $attrs>";
}