<?php
function init() {
	global $config;

	$root = str_replace("/index.php", "", $_SERVER["SCRIPT_FILENAME"]);

	$protocol = (!empty($_SERVER['HTTPS']) 
					&& $_SERVER['HTTPS'] !== 'off' 
					|| $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
	$subdir = str_replace("/index.php", "", $_SERVER['SCRIPT_NAME']);
	$path = $protocol . $host . $subdir;
	
	$config["root"] = $root;
	$config["path"] = $path;

	routing();
}

function routing() {
	global $config;

	$requests = requests();
	$controller = get_controller();

	# Routing
	if(!$controller) {
		$controller = $config["default-controller"];

		if(!$controller) {
			echo "<span style='color:#900'>No default controller set!</span><br />";
		} else {
			load_controller($controller);
		}
	} else {
		load_controller($controller);
	}
}

function requests() {
	$uri = explode('/', $_SERVER['REQUEST_URI']);

	# Trimming sub folders name in case project is in sub folders
	$path = explode('/',$_SERVER['SCRIPT_NAME']);
	for($i = 0; $i < sizeof($path); $i++) {
		if ($uri[$i] == $path[$i]) {
			unset($uri[$i]);
		}
	}

	# Filter request array
	$uri = array_filter($uri, "filter_request_array");

	# Re-Index request array
	$requests = array_values($uri);
	return $requests;
}

function get_controller() {
	global $config;

	$requests = requests();
	
	if($requests[0])
		return $requests[0];
	else
		return $config['default-controller'];
}

## Array Filter Call Back
function filter_request_array($element) {
	# Remove everything excepts Alphu-Num, dash and underscore
	return preg_replace('/\W\-\_/si', '', $element);
}

function load_controller($controller) {
	global $config, $route;

	$script = "controllers/{$controller}.php";

	# Create up routing variables
	$requests = requests();
	for($i = 0; $i < count($route); $i++) {
		$$route[$i] = $requests[$i];
	}

	if(file_exists($script)) {
		$model = "models/{$controller}.php";
		if(file_exists($model)) {
			include($model);
		}

		include($script);
	} else {
		include("404.html");
	}
}

function render($template, $data = array()) {
	global $config, $route;

	# Create routing variables
	$requests = requests();
	$controller = get_controller();

	$template = "views/{$controller}/{$template}.php";

	# Setting route variables
	for($i = 0; $i < count($route); $i++) {
		$$route[$i] = $requests[$i];
	}

	# Setting data params variables
	foreach($data as $key => $value) {
		$$key = $value;
	}

	if(file_exists($template)) {
		include("template/index.php");
	} else {
		echo "<span style='color:#900'>View missing! Create - $template</span><br />";
	}
}

function redirect($url) {
	global $config;

	if(!preg_match("/^https?:\/\//", $url))
		$url = "{$config['path']}/$url";

	if (headers_sent()) {
		echo "<script>document.location.href='$url';</script>\n";
	} else {
		@ob_end_clean();				# clear output buffer
		header( "Location: ". $url );
	}
	exit(0);
}

function load_model($model) {
	global $config;

	$file = "{$config['root']}/models/{$model}.php";

	if(file_exists($file)) {
		include_once($file);
	} else {
		echo "Cannot load model - $model";
	}
}
