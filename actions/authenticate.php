<?php
extract($_POST);
$context = 'login';
if(isset($_GET['logout'])) {
	// Remove user from session data
	unset($_SESSION['user']);
	$message = null;
	$context = null;
	$location = './?p=login';
} elseif($username != '' && $password != '') {	// If a username AND password were entered
	$user = User::match(array('username' => $username,'password' => md5($password)));
	
	if($user != null) {		// User found
		$_SESSION['user'] = $user;
		$message = "Welcome back, {$user->firstname}!";
		$context = null;
		$location = './';
	} else {					// User not found
		$message = 'You have entered an invalid username and password combination. Please try again.';
		$location = './?p=login';
	}
} else {		// Either username or password is missing
	$message = 'Please enter a username and password.';
	$location = './?p=login';
}
redirect($location,$message,$context);