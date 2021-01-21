<?php
namespace Component;

class CaptchaComponent extends Component {
	private $classes;

	public function __construct($classes = "") {
		parent::__construct(new CaptchaController());
		$this->classes = $classes;
	}

	/**
	 * @inheritDoc
	 */
	protected function calculateRender() {
		$this->controller->captcha($this->classes);
	}
}
