<!DOCTYPE html>
<html>
<head lang="en-US">
	<meta charset="utf-8">
	<title>TinyMVC - PHP Micro-Framework</title>

	<meta name="description" content="TinyMVC is a PHP micro-framework that bundle with MVC pattern and responsive web design boilarplate.">

	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="touch.png">

	<?= include_css("base.css", "all") ?>
	<?= include_css("layout.css", "all and (min-width: 33.236em)") ?>

	<!--[if (lt IE 9) & (!IEMobile)]>
	<?= include_css("layout.css", "all") ?>
	<![endif]-->

	<?= include_js("libs/modernizr.js") ?>
</head>
<body>

	<div id="container" class="cf">
		
		<header>
			<h1 role="brand">
				Tiny<span>MVC</span>
			</h1>
		</header>

		<nav>
			<ul>
				<li>
					<?= link_to("", "Home", "TinyMVC Home", "", $action==""?"active":"") ?>
				</li>
				<li>
					<?= link_to("home/about/", "About", "Project Readme", "", 
						$action=="about"?"active":"") ?>
				</li>
				<li>
					<?= link_to("home/contact/", "Contact", "Contact Us", "",
						$action=="contact"?"active":"") ?>
				</li>
				<li>
					<?= link_to("home/readme/", "Readme", "Project Readme", "",
						$action=="readme"?"active":"") ?>
				</li>
				<li>
					<?= link_to("home/license/", "License", "MIT License", "",
						$action=="license"?"active":"") ?>
				</li>
				<li><a href="https://github.com/eimg/tinymvc/archive/master.zip">Download</a></li>
			</ul>
		</nav>
		
		<div id="main" role="main">
			<? include $template ?>
		</div>
		
		<footer>
			<p class="legal">
				<?= link_to("home/license", "The MIT License") ?>: Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated files without restriction, including without limitation the rights to use, copy, modify, and distribute.
			</p>
			<p class="copy">
				&copy; Copyright 2013. All right reserved.
			</p>
		</footer>
		
	</div>
	
	<?= include_js("libs/jquery.js") ?>
	<?= include_js("app.js") ?>
</body>
</html>