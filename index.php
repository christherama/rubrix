<?php

// Start the session
session_start();

// Set the error reporting level
error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE);

// Load configuration files
require_once('config/db.php');
require_once('config/app.php');

// Load functions
require_once('functions.php');

// Set current page
$CURR_PAGE = isset($_GET['p']) ? $_GET['p'] : DEFAULT_VIEW;
$action = isset($_GET['action']) ? $_GET['action'] : null;
$ajax = isset($_GET['ajax']) ? true : false;

// If user is logged in, or is trying to login, let them
if(hasPermission()) {
	// If no action is specified
	if($action == null) {
		if(!$ajax) {
			require_once('template.php');
		} else {
			require_once('layout/content.php');
		}
	} else {
		$file = "actions/{$_GET['action']}.php";
		loadFile($file);
	}
} else { // Otherwise, force them to login
	redirect('./?p=login','You must login to do that.','login');
}
?>
