<?php if(isset($_SESSION['flash']) && !isset($_SESSION['flash']['context'])): ?>
	<div class="alert alert-block">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		<p><?php echo $_SESSION['flash']['message'];?></p>
	</div>
	<?php 
	unset($_SESSION['flash']);
endif;

// Write scripts if set
if(isset($_SESSION['scripts'])) {
	foreach($_SESSION['scripts'] as $script) {
		echo "<script>$script</script>";
	}
	unset($_SESSION['scripts']);
}

$file = "views/$CURR_PAGE.php";
if(file_exists($file)) {
	include($file);
} else {
	include('views/404.php');
}