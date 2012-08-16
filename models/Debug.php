<?php
class Debug {
	public static function o($obj) {
		echo '<pre>';
		var_dump($obj);
		echo '</pre>';
	}
	
	public static function arr($arr) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
}