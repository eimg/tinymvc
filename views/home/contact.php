<? if($action == "send-error"): ?>
<div class="error-msg">
	Something went wrong! Please enter all fields and try again.
</div>
<? endif; ?>

<div class="info" id="contact-form">
	<h2>Contact Us</h2>
	<p>Please use following form to send email to us. All fields are required. *</p>

	<?= form("home/send") ?>
		<input type="text" name="name" placeholder="your name">
		<input type="text" name="email" placeholder="your email">
		<textarea name="msg" placeholder="your message"></textarea>

		<div class="submit-field">
			<input type="submit" value="Send">
		</div>
	</form>

	<p>
		TinyMVC is a project from Fairway Web Development. You can find contact detial in Fairway Web <a href="http://fairwayweb.com/contact/">contact</a> page. And please follow our news on <a href="http://www.facebook.com/fairwayweb/">Facebook</a>.
	</p>
</div>