<!doctype html>
<html lang="en">
<head>
	<title>Test web service</title>
	<script type='text/javascript' src='<?php echo WEBSITE_ROOT?>static/js/jquery/jquery-1.6.2.js'></script>
	<script type="text/javascript" src="<?php echo WEBSITE_ROOT?>static/js/hideshow.js"></script>
	
	<style>
	<!--
	h2, h3 {
	margin-bottom: 0;
	cursor: pointer;
	}
	ul {
	margin-top: 0;
	}
	
	h2 a, h3 a {
		float: right;
		cursor: pointer;
		font-size: 11px;
		color: #f66;
	}
	-->
	</style>
</head>

<body>
<h2>AUTH</h2>
<ul class="toggle">
	<li><a href="<?= site_url('test/auth/create_account')?>" target="input_view">Create Account</a></li>    
	<li><a href="<?= site_url('test/auth/login')?>" target="input_view">Login</a></li>	
</ul>
</body>
</html>

