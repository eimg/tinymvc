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
			$data = array("msg" => "No default controller set!");
			respond($data, 500);
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

	$method = $_SERVER['REQUEST_METHOD'];

	if(file_exists($script)) {
		$model = "models/{$controller}.php";
		if(file_exists($model)) {
			include($model);
		}

		include($script);

		// Action mapping
		$map = "controllers/{$controller}.map.php";
		if(file_exists($map)) {
			include($map);
			
			if(isset($$method)) {
				if(isset($requests[1])) {
					$map = $$method;
					if(function_exists($map[$requests[1]])) {
						$map[$requests[1]]();
					} else {
						$data = array("msg" => "Action not found in action map!");
						respond($data, 404);
					}
				} else {
					// Fire up index() for blank action
					if(function_exists(index)) {
						index();
					} else {
						$data = array("msg" => "index() function not defined in controller!");
						respond($data, 404);
					}
				}
			}
		}
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

function redirect($url, $status = 301) {
	global $config;

	if(!preg_match("/^https?:\/\//", $url))
		$url = "{$config['path']}/$url";

	if (headers_sent()) {
		echo "<script>document.location.href='$url';</script>\n";
	} else {
		@ob_end_clean();				# clear output buffer
		
		if($status == 301) header("HTTP/1.1 301 Moved Permanently");
		if($status == 307) header("HTTP/1.1 307 Temporary Redirect");
		
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
		$data = array("msg" => "Cannot load model - $model");
		respond($data, 500);
	}
}

function respond($data, $status = 200, $type = "json") {
	# Use redirect() for 301 and 307
	switch($status) {
		case 200:
			header("HTTP/1.1 200 OK");
			break;
		case 204:
			header("HTTP/1.1 204 No Content");
			break;
		case 304:
			header("HTTP/1.1 304 Not Modified");
			break;
		case 400:
			header("HTTP/1.1 400 Bad Request");
			break;
		case 401:
			header("HTTP/1.1 401 Unauthorized");
			break;
		case 403:
			header("HTTP/1.1 403 Forbidden");
			break;
		case 404:
			header("HTTP/1.1 404 Not Found");
			break;
		case 405:
			header("HTTP/1.1 405 Method Not Allowed");
			break;
		case 410:
			header("HTTP/1.1 410 Gone");
			break;
		case 429:
			header("HTTP/1.1 429 Too Many Requests");
			break;
		case 500:
			header("HTTP/1.1 500 Internal Server Error");
			break;
		case 503:
			header("HTTP/1.1 503 Service Unavailable");
			break;
		default:
			header("HTTP/1.1 " . $status);
	}

	switch($type) {
		case "json":
			header("Content-type: application/json");
			echo json_encode($data);
			break;
		case "jsonp":
			header("Content-type: text/javascript");
			echo json_encode($data);
			break;
		case "html":
			header("Content-type: text/html");
			echo $data;
			break;
		case "text":
			header("Content-type: text/plain");
			echo $data;
			break;
		default:
			//
	}
}

function template($file, $data = array()) {
	global $config, $route;

	$requests = requests();
	$template = "views/templates/{$file}";

	for($i = 0; $i < count($route); $i++) {
		$$route[$i] = $requests[$i];
	}

	foreach($data as $key => $value) {
		$$key = $value;
	}

	if(file_exists($template)) {
		header("Content-type: text/html");
		include($template);
	} else {
		respond("Template missing at $template", 500, "text");
	}
}

function generate_user_id($var) {
	$id = substr(sha1($var), 0, 7);

	return $id;
}

function generate_api_key($var, $random = false) {
	$salt = "9x8y7z";
	$secret = "!@#$%^";

	if($random) {
		$key = md5(time() . $secret . $var . rand());
	} else {
		$key = md5($salt . $secret . $var);
	}
	
	return $key;
}

function http_auth() {
	$valid_passwords = array ("user" => "pass", "guest" => "guest");
	$valid_users = array_keys($valid_passwords);

	$user = $_SERVER['PHP_AUTH_USER'];
	$pass = $_SERVER['PHP_AUTH_PW'];

	$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

	if (!$validated) {
	  header('WWW-Authenticate: Basic realm="Restricted Area"');
	  header('HTTP/1.0 401 Unauthorized');
	  die ("Not authorized");
	}

	return true;
}