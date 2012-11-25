<?php $student = Student::match(array('id' => $_GET['id'])); ?>
<h1><?php echo $student->name() ?></h1>