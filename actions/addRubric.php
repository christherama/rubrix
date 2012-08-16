<?php

extract($_POST);

$rubric = new Rubric();
if($rubric->validate()) {
	if($rubric->save()) {
		$id = Rubric::$lastInsertId;
		$location = "./?p=rubric&id=$id";
		addScript('toggleRubricForm(true)');
		addScript("addRubricToDropdown('$id','{$rubric->name}');");
	}
} else {
	$location = './?p=newRubric';
	$message = 'Please provide all information.';
}
redirect($location,$message);
