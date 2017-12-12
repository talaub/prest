<?php

function test ($output) {
	$t = array();
	$t["output"] = $output;
	echo json_encode($t);

}

$routes = array();

$routes["/"] = function () use ($PARAMS) {
	test("root");

};

$routes["test"] = function () use ($PARAMS) {
	if (isset($PARAMS["name"]))
		test($PARAMS["name"]);
	else
		test("tescht");

};

$routes[":name"] = function ($VALUES) use ($PARAMS) {
	test($VALUES["name"]);

};

$routes[":name/bodypart/:bodypart"] = function ($VALUES) use ($PARAMS) {
	test($VALUES["name"]."   ".$VALUES["bodypart"]);

};

?>