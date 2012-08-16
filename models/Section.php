<?php
class Section extends DataModel {
	public static function findCurrent() {
		$sql = 'SELECT sections.*, courses.abbrev FROM semesters INNER JOIN sections ON semesters.id=sections.semester_id INNER JOIN courses ON courses.id=sections.course_id WHERE NOW() >= semesters.datestart AND NOW() <= semesters.dateend ORDER BY courses.name';
		$results = parent::exec($sql,null,'Section');
		$courses = array();
		foreach($results as $section) {
			$courses[$section->abbrev]['sections'][] = array('id' => $section->id, 'block' => $section->block);
		}
		return $courses;
	}
	
}