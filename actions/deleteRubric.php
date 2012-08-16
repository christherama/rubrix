<?php 
$location = './';
$rubric = Rubric::match(array('id' => $_POST['id']));
if($rubric != null){
	if($rubric->delete()) {
		$message = 'The rubric has been successfully deleted.';
		addScript("removeRubricFromDropdown({$_POST['id']})");
	} else {
		$location = "./?p=rubric&id={$_POST['id']}";
		$message = 'There was a problem deleting the rubric. Please try again.';
	}
} else {
	$message = 'That rubric does not exist, deleting it seems strange...';
}
redirect($location,$message);
