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
	                $( '#' + id ).change();
	            }
			};
			$(this).slider(options);
		});

		$('input.score').change(updateTotals);

		function updateTotals() {
			var sub = 0;
			var extra = 0;
			
			$('input.score').each(function(){
				if($(this).parent('li').attr('data-criterion-extracredit') == 0) {
					sub += parseInt($(this).val());
				} else {
					extra += parseInt($(this).val());
				}
			});
			var grand = sub + extra;
			$('#sub-total').html(sub);
			$('#extra-total').html(extra);
			$('#grand-total').html(grand);
		}
	</script>
<?php else:?>
	<div class="alert alert-error"><p>That rubric does not exist. What the...</p></div>
<?php endif;?>