<?php
$rubric = Rubric::match(array('id' => $_GET['rubric']));
$rubric->grading = true;
if($rubric != null): ?>
	<?php echo $rubric->getGradingForm();?>
	<script>
		$('div.slider').each(function() {
			var li = $(this).parent('li');
			var max = li.attr('data-criterion-weight');
			var id = 'criterion-' + li.attr('data-criterion-id');
			var options = {
				value:0,
	            min: 0,
	            max: max,
	            step: 1,
	            slide: function( event, ui ) {
	                $( '#' + id ).val( ui.value );
	            }
			};
			$(this).slider(options);
		});
	</script>
<?php else:?>
	<div class="alert alert-error"><p>That rubric does not exist. What the...</p></div>
<?php endif;?>