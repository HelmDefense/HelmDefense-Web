<?php
namespace Module;

use Utils;

class PanelModoController extends Controller {
	public function __construct() {
		parent::__construct(new PanelModoModel(), new PanelModoView());
	}

	public function verifyAccess() {
		Utils::restrictAccess(null,
				"Vous n'êtes pas autorisé à accéder au panel de modération sans être connecté",
				"Vous n'avez pas accès au panel de modération",
				"moderator");
	}

	public function listUsers($p, $limit) {
		if ($p <= 0)
			Utils::error(400, "Numéro de page invalide");
		if ($limit <= 0)
			Utils::error(400, "Nombre d'éléments invalide");
		$users = $this->model->users($p, $limit);
		if (!$users->result)
			Utils::error(400, "Page invalide");
		$this->view->displayList($users->result, $users->count, $limit, $p);
	}

	public function warn($id, $reason) {
		$this->model->addSanction($id, 1, $reason);
		Utils::redirect("/panel/modo");
	}

	public function ban($id, $reason) {
		$this->model->addSanction($id, 2, $reason);
		Utils::redirect("/panel/modo");
	}
}
