<?php
namespace Component;

use Utils;

class CaptchaModel extends Model {
	public function sitekey() {
		return Utils::config("captcha.sitekey");
	}
}
