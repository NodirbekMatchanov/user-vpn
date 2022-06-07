<?php

global $hash;
$hash2 = filemtime('css/styles.css');
$hash3 = filemtime('js/base.js');
$hash = hash('ripemd160', $hash2 . $hash3);

if(isset($_GET['utm_source'])) setcookie("utm_source", $_GET['utm_source'], time() + 1892160000);
if(isset($_GET['utm_medium'])) setcookie("utm_medium", $_GET['utm_medium'], time() + 1892160000);
if(isset($_GET['utm_campaign'])) setcookie("utm_campaign", $_GET['utm_campaign'], time() + 1892160000);
if(isset($_GET['utm_term'])) setcookie("utm_term", $_GET['utm_term'], time() + 1892160000);
if(isset($_GET['utm_content'])) setcookie("utm_content", $_GET['utm_content'], time() + 1892160000);

function get_part($path, $vars = []) {
	global $hash;

	$vars = (object) $vars;
	$path = $path;
	if (strpos($path, '.') === false) {
		$path .= '.php';
	}
	$path = __DIR__ . '/' . $path;

	// if (file_exists($path))
	include $path;
}


