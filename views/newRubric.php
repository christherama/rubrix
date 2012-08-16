<form class="form-inline well" action="./?action=addRubric" method="post">
	<h2>New Rubric</h2>
	<input type="text" name="name" placeholder="Rubric Name"/>
	<select name="course_id">
		<option value="">Select a course</option>
		<?php foreach(Course::findAll() as $course):?>
			<option value="<?php echo $course->id;?>"><?php echo $course->name;?></option>
		<?php endforeach;?>
	</select>
	<input class="btn btn-success" type="submit" value="Add" />
</form>