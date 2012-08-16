<?php
$rubric = Rubric::match(array('id' => $_GET['id']));
if($rubric != null): ?>
	<?php echo $rubric;?>
<?php else:?>
	<div class="alert alert-error"><p>That rubric does not exist. What the...</p></div>
<?php endif;?>