<?php
function throw404() {
	header("HTTP/1.0 404 Not Found");
	$result = array();
	$result["response"] = "error";
	$result["info"] = array();
	$result["info"]["type"] = "http";
	$result["info"]["code"] = "404";
	$result["info"]["message"] = "Not Found";
	echo json_encode($result);
	die();

}

function throw405() {
	header("HTTP/1.0 405 Method Not Allowed");
	$result = array();
	$result["response"] = "error";
	$result["info"] = array();
	$result["info"]["type"] = "http";
	$result["info"]["code"] = "405";
	$result["info"]["message"] = "Method Not Allowed";
	echo json_encode($result);
	die();

}
?>