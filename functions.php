<?php
// Load rubrics into session data if not set
if(!isset($_SESSION['rubrics'])) {
	$_SESSION['rubrics'] = get_rubrics();
}

/**
 * Reads XML rubric files into an array of
 * Rubric objects
 * @return Array of Rubric objects
 */
function get_rubrics() {
	$rubrics = array();
	
	// Open directory for reading
	$dir = dir('rubrics');
	
	// Read all files
	while($file = $dir->read()) {
		// If the file is an XML file
		if(strtolower(substr($file,-4)) == '.xml') {
			// Use file name as ID
			$id = substr($file,0,strlen($file)-4);
			
			$xmlStr = file_get_contents('rubrics/'.$file);
			$rubric = new Rubric($id,$xmlStr);
			$rubrics[] = $rubric;
		}
	}
	
	// Close the directory
	$dir->close();
	
	return $rubrics;
}

/**
 * Fetch Rubric with specified ID
 * @param String $id
 * @return Rubric Rubric with specified ID
 */
function get_rubric($id) {
	foreach($_SESSION['rubrics'] as $rubric) {
		if($rubric->id == strtolower($id)) {
			return $rubric;
		}
	}
	return null;
}

function hasPermission() {
	global $PUBLIC, $action, $CURR_PAGE;
	if(isLoggedIn()) return true;
	foreach($PUBLIC['actions'] as $a) {
		if($action == $a) return true;
	}
	foreach($PUBLIC['views'] as $v) {
		if($CURR_PAGE == $v) return true;
	}
	return false;
}


/**
 * Determines whether or not the user is logged in
 * @return True if logged in, false if not
 */
function isLoggedIn() {
	return isset($_SESSION['user']);
}

/**
 * Loads the file, if it exists. If the file doesn't exist, 
 * a location header for the 404 page is sent back to the browser
 * @param String $file File to load
 */
function loadFile($file) {
	if(file_exists($file)) {
		require_once($file);
	} else {
		header('Location:./?p=404');
	}
}

/**
 * PHP magic method for auto loading classes. Without this, you would be
 * forced to require_once('path/to/Class.php') upon creating any of your objects
 * @param String $className Name of class to load
 */
function __autoload($className) {
	require_once("models/$className.php");
}

/**
 * Helper function to send location headers, with an optional message
 * @param String $location Absolute or relative URL of destination
 * @param String $message Optional message to display upon redirection
 */
function redirect($location,$message=null,$context=null,$full_redirect=false) {
	if($message != null) {
		$_SESSION['flash'] = array('message' => $message, 'context' => $context);
	}
	if(!$full_redirect) {
		$location = resolveAjaxUrl($location);
	} else {
		addScript("window.location=\"$location\";");
	}
	header("Location:$location");
}

function resolveAjaxUrl($location) {
	if(isset($_GET['ajax'])) {
		$append = !strpos($location,'?') ? '?' : '&';
		$location .= "{$append}ajax=true";	
	}
	return $location;
}

function addScript($script) {
	$_SESSION['scripts'][] = $script;
}