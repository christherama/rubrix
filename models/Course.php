<?php
class Course extends DataModel {
	public static function findAll() {
		return parent::find('Course',null,'name');
	}
}