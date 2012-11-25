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

	/**
	 * Gets a section & roster based on the provided section id
	 */
	public static function findById($id) {
		$sql_course = "SELECT courses.name FROM courses INNER JOIN sections ON sections.course_id=courses.id WHERE sections.id=$id";
		$section = parent::exec($sql_course,null,'Section');
		$section = $section[0];
		$sql_roster = "SELECT students.* FROM students INNER JOIN rosters ON students.id=rosters.student_id WHERE rosters.section_id=$id";
		$students = parent::exec($sql_roster,null,'Student');
		$section->students = $students;
		return $section;
	}
	
}