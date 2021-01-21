<?php
namespace Module;

Use Utils;

class PanelAdminController extends Controller {
	public function __construct() {
		parent::__construct(new PanelAdminModel(), new PanelAdminView());
	}

	public function verifyAccess() {
		Utils::restrictAccess(null,
				"Vous n'êtes pas autorisé à accéder au panel d'administration sans être connecté",
				"Vous n'avez pas accès au panel d'administration",
				"administrator");
	}

	public function list($p, $limit) {
		if ($p <= 0)
			Utils::error(400, "Numéro de page invalide");
		if ($limit <= 0)
			Utils::error(400, "Nombre d'éléments invalide");
		$users = $this->model->users($p, $limit);
		if (!$users->result)
			Utils::error(400, "Page invalide");

		$this->view->displayList($users->result, $users->count, $limit, $p);
	}

	public function displayProfileRole($id) {
		if($id == null)
			Utils::error(400, "Login invalide");
		$user = $this->model->getUser($id);
		if(!$user)
			Utils::error(404, "L'utilisateur n°" .  htmlspecialchars($id) . " n'existe pas");

		$this->model->defineRanks($user);
		$this->title = "$id - Édition de page";
		$this->view->displayProfileRole($user);
		Utils::timeout("delete", 300);
	}

	public function editRole($id, $login, $admin, $dev, $modo, $redac) {
		if ($this->model->editRole($id, $login, $admin, $dev, $modo, $redac)) {
			header("Location: /panel/admin");
			exit;
		} else
			Utils::error(404, "L'utilisateur n°" .  htmlspecialchars($id) . " n'existe pas");
	}

}