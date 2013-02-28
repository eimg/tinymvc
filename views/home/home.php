<? if($action == "send-success"): ?>
<div class="success-msg">
	Thanks for your message. We'll get in touch!
</div>
<? endif; ?>

<div class="hero">
	<div class="figure"></div>
	<div class="welcome">
		<h2>The Most Simplest PHP Micro-Framework</h2>
		<p>
			TinyMVC is a PHP micro framework with MVC router and responsive web design boilerplate, especially designed to quickly bootstrap web apps without unnecessary overhead and complexity. The structure and code are construct in simple imperative manner. <?= link_to("home/about", "Learn more") ?> &raquo;
		</p>

		<?= link_to("https://github.com/eimg/tinymvc/archive/master.zip", "Download",
			"Download TinyMVC", "",	"primary-action") ?>

		<?= link_to("https://github.com/eimg/tinymvc", "Fork on Github", 
			"Fork TinyMVC on Github", "", "secondary-action") ?>
	</div>
</div>

<div class="feature">
	<div class="column">
		<div class="feature-img">
			<?= image("be-responsive-logo.png") ?>
		</div>
		<div class="feature-content">
			<h3>beResponsive</h3>
			<p>
				A simple template boilerplate to quickly bootstrap responsive websites. Based on The Goldilocks Approach and HTML5Boilerplate. <?= link_to("https://github.com/eimg/be-responsive", "Learn more") ?> &raquo;
			</p>
		</div>
	</div>

	<div class="column">
		<div class="feature-img">
			<?= image("tiny-note-logo.png") ?>
		</div>
		<div class="feature-content">
			<h3>TinyNote</h3>
			<p>
				A note taking app created with TinyMVC PHP micro framework for learning purpose as the usage of framework. <?= link_to("https://github.com/eimg/tinynote", "Learn more") ?> &raquo;
			</p>
		</div>
	</div>
</div>