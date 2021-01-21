<?php
namespace Component;

class CaptchaComponent extends Component {
	private $form;
	private $classes;

	public function __construct($form = "form", $classes = "") {
		parent::__construct(new CaptchaController());
		$this->form = $form;
		$this->classes = $classes;
	}

	/**
	 * @inheritDoc
	 */
	protected function calculateRender() {
		$this->controller->captcha($this->form, $this->classes);
	}
}
