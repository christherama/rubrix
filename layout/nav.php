<?php if($CURR_PAGE != 'login'):?>
<?php 
// Get all current sections grouped by course
$courses = Section::findCurrent();
$rubrics = Rubric::findAll();

?>
<ul class="nav pull-left">
	<li>
		<a href="./"><i class="icon-th icon-white"></i></a>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="icon-folder-open icon-white"></i>
			<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<?php foreach($courses as $abbrev => $course):?>
				<li class="nav-header"><?php echo $abbrev;?></li>
				<?php foreach($course['sections'] as $section):?>
					<li><a href="./?p=section&id=<?php echo $section['id'];?>">Block <?php echo $section['block'];?></a></li>
				<?php endforeach;?>
			<?php endforeach;?>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="icon-pencil icon-white"></i>
			<b class="caret"></b>
		</a>
		<ul id="dropdown-rubrics" class="dropdown-menu">
			<?php foreach($rubrics as $rubric):?>
				<li data-id="<?php echo $rubric->id;?>" class="rubric"><a href="./?p=rubric&id=<?php echo $rubric->id;?>"><?php echo $rubric->name;?></a></li>
			<?php endforeach;?>
			<li class="divider"></li>
			<li><a href="./?p=newRubric">New Rubric</a></li>
		</ul>
	</li>
</ul>
<form class="navbar-search pull-left" action="./">
	<input type="hidden" name="p" value="students">
	<input type="text" class="search-query" name="q" placeholder="search students" autocomplete="off">
</form>
<span class="nav-status pull-left"></span>
<span class="nav-message pull-left"></span>
<ul class="nav pull-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	    		<?php echo isLoggedIn() ? $_SESSION['user']->firstname : '';?> <i class="icon-user icon-white"></i>
			<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><a href="./?p=settings">Settings</a></li>
	     	<li><a href="./?action=authenticate&logout=true" class="noajax">Logout</a></li>
		</ul>
	</li>
</ul>
<?php endif;?>