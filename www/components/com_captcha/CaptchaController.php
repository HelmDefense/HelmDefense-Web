<?php
namespace Component;

class CaptchaController extends Controller {
	public function __construct() {
		parent::__construct(new CaptchaModel(), new CaptchaView());
	}

	public function captcha($classes) {
		$this->view->captcha($this->model->sitekey(), $classes);
	}
}
