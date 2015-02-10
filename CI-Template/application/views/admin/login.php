<!doctype html>
<html lang="en">
<title>Login: <?=SITE_TITLE?> Dashboard</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='stylesheet' href='static/css/dashboard.css' type='text/css' />
</head>

<body class="login" id="main">
	<article class="module width_full" id="login" style="width: 420px; margin: 120px auto;">
		<header><h3><?= SITE_TITLE?> Dashboard Login</h3></header>
<?php
	echo $user->render_form(array(
			'username'=>array("style"=>'width:350px'),
			'password'=>array("style"=>'width:350px', "type"=>"password")
		),
		'admin/auth/login',
		array(
			'save_button' => 'Log In',
			'reset_button' => 'Clear'
		),
		"html5form/form_1"
	);
?>
	</article>
</body>
</html>