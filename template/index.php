<!DOCTYPE html>
<html>
<head lang="en-US">
	<meta charset="utf-8">
	<title>Tiny - REST</title>

	<?= include_css("bootstrap.css") ?>
	<?= include_css("style.css") ?>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="#">Tiny REST</a>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li><?= link_to("home", "Home") ?></li>
						<li><?= link_to("home/about", "About") ?></li>
						<li><?= link_to("home/contact", "Contact") ?></li>
						<li><?= link_to("todo/tasks", "All Tasks") ?></li>
						<li><?= link_to("todo/task/1", "Single Task") ?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container page">
		<? include $template ?>
	</div>
	
	<?= include_js("jquery.js") ?>
	<?= include_js("bootstrap.js") ?>
	<?= include_js("app.js") ?>
</body>
</html>