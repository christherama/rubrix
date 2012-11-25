<?php 
// Get active sections (by course)
$courses = Section::findCurrent();

// Get active students
$students = Student::findCurrent();

// Get active rubrics
$rubrics = Rubric::findAll();

// TODO:Get something else

?>

<div id="dashboard" class="row">
	<div class="span6">
		<h2>Courses</h2>
		<div class="scrollable scrollable2">
			<?php foreach($courses as $abbrev => $course):?>
				<h3><?php echo $abbrev?></h3>
				<ul>
					<?php foreach($course['sections'] as $section):?>
						<li><a href="./?p=section&amp;id=<?php echo $section['id']?>">Block <?php echo $section['block']?></a></li>
					<?php endforeach;?>
				</ul>
			<?php endforeach;?>
		</div>
		<h2>Rubrics</h2>
		<div class="scrollable scrollable2">
			<img src="http://placehold.it/452x268&amp;text=Rubrics" alt="" />
		</div>
	</div>
	<div class="span6 students">
		<h2>Students</h2>
		<div class="scrollable vertical">
			<ul>
				<?php foreach($students as $student):?>
					<li><?php echo $student;?></li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>
