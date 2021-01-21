<?php
namespace Component;

class CaptchaController extends Controller {
	public function __construct() {
		parent::__construct(new CaptchaModel(), new CaptchaView());
	}

	public function captcha($form, $classes) {
		$this->view->captcha($form, $this->model->sitekey(), $classes);
	}
}
