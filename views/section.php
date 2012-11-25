<?php $section = Section::findById($_GET['id']) ?>
<ul>
<?php foreach($section->students as $s): ?>
	<li><?php echo $s ?></li>
<?php endforeach; ?>
</ul>