<?php
/*
* All common function hear
*/

session_start();

// get config function
function get_config($replace=null){
	static $config = [];
	
	if (file_exists(APP.'config/config.php')) {
		include_once APP.'config/config.php';
	}
	if ($replace != null) {
		if (array_key_exists($replace, $config)) {
			// store all config array in config variable. 
			foreach ($config as $key => $val) {
				$config[$key] = $val;
			}
		} else {
			die("config item not found");
		}
	}
	
	if (!empty($replace)) {
		return $config[$replace];
	}
	// return $config;
}

function dd($arg) {
	print_r($arg);
}

// base url function
function base_url($dir = null) {
	$base_url = get_config('base_url');
	
	if ($dir != null) {
		return $base_url.$dir;
	} else {
		return $base_url;
	}
}

// view function $vars = array()
function view($path=null, $var_array = array()) {
	// send data
	if ($var_array != null) {
		extract($var_array);
	} else {
		$var_array = '';
	}

	if ($path != null && $path !== '') {
		// set requested file path
		$file = VIEW.$path.".php";
		// check file existance
		if (file_exists($file)) {
			include_once $file;
		} else {
			echo "Your request file is not found";
		}

	} else {
		echo "Your path is empty! Enter a path into view function. <br>";
	}
}

// function redirect($url) {
//     header("location: " . $url);
// 	// header('Location: domain.com/down.php', true, 410);
// }
// 404 error function
function _404() {
	http_response_code(404);
	include_once VIEW."error/404.html";
}
function str_limit($string, $limit) {
	$string = strip_tags($string);
	if (strlen($string) > $limit) {

		// truncate string
		$stringCut = substr($string, 0, $limit);
		$endPoint = strrpos($stringCut, ' ');

		//if the string doesn't contain any space then it will cut without word basis.
		$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
		$string .= '...';
	}
	return $string;
}

// route error function
function _route_error() {
	include_once VIEW."error/route_error.html";
}



function redirect($url) {
	return new class($url) {
		public function __construct($url)
		{
			$this->url = $url;
			header("location: " . $url);
		}

		public function with($name, $value)
		{
			$_SESSION[$name] = $value;
		}
	}; 
}

function message($name) {
	$session = false;
	if (isset($_SESSION[$name])) {
		$session = $_SESSION[$name];
		session_unset();
	}
	if ($session) {
		return '<div class="alert alert-success d-flex align-items-center" role="alert">
				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
				<div>
				'.$session.'
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left:auto;"></button>
			</div>';
	}
}
