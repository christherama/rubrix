<?php
class Student extends DataModel {
	public static function findCurrent() {
		$sql = 'SELECT students.* FROM semesters 
					INNER JOIN sections ON semesters.id=sections.semester_id
					INNER JOIN rosters ON sections.id=rosters.section_id
					INNER JOIN students ON rosters.student_id=students.id
				WHERE NOW() >= semesters.datestart AND NOW() <= semesters.dateend
				ORDER BY students.lastname, students.firstname';
		return parent::exec($sql,null,'Student');
	}
	
	public function name() {
		return $this->lastname.', '.$this->firstname;
	}
	
	public function __toString() {
		$summary  =	"<a href=\"./?p=student&id={$this->id}\">";
		$summary .=		"<img src=\"http://placehold.it/40x40\" alt=\"\"/>";
		$summary .=		"<span class=\"name\">{$this->name()}</span>";
		$summary .=	"</a>";
		return $summary;
	}
}