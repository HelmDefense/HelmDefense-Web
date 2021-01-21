<?php
namespace Component;

class CaptchaView extends View {
	public function captcha($sitekey, $classes) {
		echo "<div class='g-recaptcha $classes' data-sitekey='$sitekey'></div>";
	}
}
