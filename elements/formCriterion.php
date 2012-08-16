<div class="modal fade hide" id="criterionModal">
	<div class="modal-header">
		<h3>Add Criterion</h3>
	</div>
	<form id="form-criterion" class="form-horizontal" action="./?action=addCriterion" method="post">
		<div class="modal-body">
			
				<input type="hidden" name="rubric_id" value="<?php echo $_GET['id']?>" />
				<div class="control-group">
					<label class="control-label">Description</label>
					<div class="controls">
						<input type="text" name="description" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Weight</label>
					<div class="controls">
						<input type="number" name="weight" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Extra Credit</label>
					<div class="controls">
						<input type="checkbox" name="extracredit" />
					</div>
				</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Cancel</a> <input type="submit" class="confirm btn btn-success" value="Add" />
		</div>
	</form>
</div>