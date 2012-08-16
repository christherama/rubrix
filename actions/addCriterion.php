<?php
extract($_POST);

$criterion = new Criterion();
if($criterion->validate()) {
	$criterion->extracredit = isset($extracredit) ? 1 : 0;
	if($criterion->save()) {
		$message = 'Your criterion has been added.';
	}
} else {
	$message = 'You did not provide all information for the criterion. Please try again.';
}
$location = "./?p=rubric&id=$rubric_id";

addScript("showNavMessage('$message')");
addScript('toggleRubricForm(true)');
redirect($location);