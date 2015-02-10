<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title><?=SITE_TITLE?> Dashboard Admin Panel</title>
	
	<link rel="stylesheet" href="<?php echo WEBSITE_ROOT?>static/css/dashboard.css" type="text/css" media="screen" />
	
	<link rel="stylesheet" href="<?php echo WEBSITE_ROOT?>static/css/jquery_ui/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo WEBSITE_ROOT?>static/css/jquery_ui/jquery-ui-timepicker-addon.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo WEBSITE_ROOT?>static/css/jquery_ui/validationEngine.jquery.css" type="text/css" media="screen" />
	
	<?php if ($this->agent->browser() == 'Internet Explorer'):?>
	<!--[if lt IE 9]> -->
	<link rel="stylesheet" href="<?php echo WEBSITE_ROOT?>static/css/ie.css" type="text/css" media="screen" />
	<script src="<?php echo WEBSITE_ROOT?>static/js/html5.js"></script>
	<!-- <![endif]-->
	<?php endif;?>
	<script type='text/javascript' src='<?php echo WEBSITE_ROOT?>static/js/jquery/jquery-1.6.2.js'></script>
	<script type='text/javascript' src='<?php echo WEBSITE_ROOT?>static/js/jquery/jquery-ui-1.8.16.custom.min.js'></script>
	<script type='text/javascript' src='<?php echo WEBSITE_ROOT?>static/js/jquery/jquery-ui-timepicker-addon.js'></script>
	<script type='text/javascript' src='<?php echo WEBSITE_ROOT?>static/js/jquery/jscript_jquery.validationEngine-en.js'></script>
	<script type='text/javascript' src='<?php echo WEBSITE_ROOT?>static/js/jquery/jscript_jquery.validationEngine.js'></script>
	<script type="text/javascript" src="<?php echo WEBSITE_ROOT?>static/js/highcharts.js"></script>
	
	<script src="<?php echo WEBSITE_ROOT?>static/js/hideshow.js" type="text/javascript"></script>
	<script src="<?php echo WEBSITE_ROOT?>static/js/jquery/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo WEBSITE_ROOT?>static/js/jquery/jquery.equalHeight.js"></script>
	
	<script type='text/javascript' src='<?php echo WEBSITE_ROOT?>static/js/general.js'></script>
	
	<script type='text/javascript'>
	/* <![CDATA[ */
		userSettings = {
			url: "/",
			uid: "1",
			time: "1235955367"
		}

		base_url = "<?php echo WEBSITE_ROOT?>";
	/* ]]> */
	</script>
</head>


<body>
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?=site_url("admin/home")?>">Admin Panel</a></h1>
			<h2 class="section_title"><?= SITE_TITLE?></h2>
			<div class="btn_view_site" id="system_time" style="color: #fff; padding-top: 5px;"></div>
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			<p><?= $this->login_user->username?></p>
			<!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs">
				<a href="<?=site_url("admin/home")?>">Admin Panel</a> 
				<?php if (is_array($this->title)):?>
					<?php for($i = 0; $i < count($this->title); $i ++):?>
						<div class="breadcrumb_divider"></div>
						<?php if(isset($this->title[$i]['url'])):?>
							<a href="<?=$this->title[$i]['url']?>"><?= $this->title[$i]['text']?></a>
						<?php else:?>
							<a class="current"><?= $this->title[$i]['text']?></a>
						<?php endif;?>
					<?php endfor;?>
				<?php else:?>
				<div class="breadcrumb_divider"></div> 
				<a class="current"><?= $this->title?></a>
				<?php endif;?>
			</article>
		</div>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<a href="<?php echo site_url("admin/home")?>"><h3>Home</h3></a>
		
		
		<h3>System</h3>
		<ul class="toggle">
		
			<li class="icn_settings"><a href="<?= site_url("admin/configurations")?>">Options</a></li>                            
			<li class="icn_profile"><a href="<?= site_url("admin/profile")?>">Admin Profile</a></li>
			<li class="icn_jump_back"><a href="<?= site_url("admin/auth/logout")?>">Log Out</a></li>
                       
		</ul>
		
		<footer>
			<!-- <hr />
			<p><strong>Copyright &copy; 2011 Website Admin</strong></p>
			<p>Theme by <a href="http://www.chengtong-yilin.com">Chengtong</a></p> -->
		</footer>
	</aside><!-- end of sidebar -->
	
	<section id="main" class="column">
		<?php my_show_error($this->session->flashdata('error'));?>
		<?php my_show_message($this->session->flashdata('message'));?>