<div class="modal">
	<form id="form-login" action="./?action=authenticate" method="post">
		<div class="modal-header">
			<h1>Please Sign In</h1>
		</div>
		<div class="modal-body">
			<?php if(isset($_SESSION['flash']) && isset($_SESSION['flash']['context']) && $_SESSION['flash']['context'] == 'login'): ?>
				<div class="alert alert-block">
					<p><?php echo $_SESSION['flash']['message'];?></p>
				</div>
				<?php 
				unset($_SESSION['flash']);
			endif; ?>
			<input type="text" name="username" placeholder="username" autocapitalize="off"/><br/>
			<input type="password" name="password" placeholder="password"/>
		</div>
		<div class="modal-footer">
			<input type="submit" class="btn btn-primary" value="Sign In" />
		</div>
	</form>
</div>