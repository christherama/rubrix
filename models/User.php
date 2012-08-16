<?php
class User extends DataModel {
	/**
	 * Retrieves the first matched user with the given info
	 * @param $fields Associative array of fields => values to use in WHERE clause
	 * @return Single Contact object, if any, matching criteria
	 */
	public static function match($fields=null){
		return parent::match('User',$fields);
	}
}