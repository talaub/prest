<?php
include_once "codes.php";
include_once "lib/string.php";

header('Content-Type: application/json');

// Gets the request method
$requested_method = $_SERVER['REQUEST_METHOD'];
$requested_method = strtolower($requested_method);

// Gets the path
$requested_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Extracts the part of the requested URI after the /api/ part
$path_list = explode("/", trim($requested_path, "/"));

$requested_path = "";
$found = false;
foreach ($path_list as $path_element) {
	if ($found)
		$requested_path .= "/" . $path_element;

	if ($path_element == end(explode("/", getcwd())));
		$found = true;
}

$requested_path = trim($requested_path, "/");

// Gets the first (most important) selector
$first_url_selector = explode("/", $requested_path)[0];

// Gets all subdirectories of the modules-directory
$module_subdirectories = glob("modules" . '/*' , GLOB_ONLYDIR);

// Check if there is a directory for the first selector, if not, a 404 is thrown
if (!in_array("modules/$first_url_selector", $module_subdirectories)) {
	throw404();
}

// Checks if the method exists for the first selector
$files = scandir("modules/$first_url_selector");
if (!in_array("$requested_method.php", $files)) {
	throw405();
}

// Create the params-variable
$PARAMS = $_GET;

// Includes all method functions
include_once "modules/$first_url_selector/$requested_method.php";

// Cuts the first url selector from the requested path
$requested_path = ltrim($requested_path, "$first_url_selector/");

if ($requested_path === "")
	$requested_path = "/";

$found = false;

foreach ($routes as $route => $func) {
	// If the route completely matches, call the function
	if (trim($route, "/") === trim($requested_path, "/")) {
		$found = true;
		$func();
	}
	else {
		$VALUES = array();

		$route_elements = explode("/", $route);
		$path_elements = explode("/", $requested_path);

		$matches = true;

		for ($i = 0; $i < count($path_elements); $i++) {
			if ($i > (count($route_elements) - 1)) {
				$matches = false;
				break;
			}

			if ($route_elements[$i] === "*")
				continue;

			if (startsWith($route_elements[$i], ":")) {
				$VALUES[ltrim($route_elements[$i], ":")] = $path_elements[$i];
				continue;
			}

			if ($route_elements[$i] != $path_elements[$i]) {
				$matches = false;
				break;
			}
		}

		if ($matches) {
			$found = true;
			$func($VALUES);
		}
	}

	// Exit the loop if a matching route was found
	if ($found)
		break;
}

if (!$found)
	throw404();

?>