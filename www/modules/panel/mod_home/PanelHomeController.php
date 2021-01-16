<?php
namespace Module;

use Utils;

class PanelHomeController extends Controller {
	public function __construct() {
		parent::__construct(new PanelHomeModel(), new PanelHomeView());
	}

	public function panel() {
		$ranks = $this->model->ranks();
		Utils::restrictAccess($ranks,
				"Vous n'êtes pas autorisé à accéder au panel de contrôle sans être connecté",
				"Vous n'avez pas accès au panel de contrôle",
				"redactor", "developer", "moderator", "administrator");
		$this->view->panel($ranks);
	}
}
