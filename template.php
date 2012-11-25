<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		
		<link rel="icon" type="image/png" href="" />
		<link rel="stylesheet" type="text/css" href="jquery/css/ui-lightness/theme.css" />
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles.css" />
		
		
		<script type="text/javascript" src="jquery/jquery.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="rubrix.js"></script>
		
		<title>Rubrix</title>
	</head>
	<body class="<?php echo $CURR_PAGE == 'login' ? 'modal-bg' : '' ?>">
		<header>
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<?php include('layout/nav.php');?>
					</div>
				</div>
			</div>
		</header>
		<div id="content">
			<?php include('layout/content.php');?>
		</div>
		<footer>
			<?php include('layout/footer.php');?>
		</footer>
	</body>
</html>