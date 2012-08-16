<?php
class Criterion extends DataModel {
	public static $plural = 'Criteria';
	var $required = array('description','rubric_id','weight');
	
	public static function find($fields) {
		return parent::find('Criterion',$fields,'extracredit, ordernum');
	}
}