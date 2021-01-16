<?php
namespace Module;

use Utils;

include_once "UserProfileModel.php";
include_once "UserProfileView.php";
include_once "modules/generic/Controller.php";

class UserProfileController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new UserProfileModel(), new UserProfileView());
	}

	public function correctUrl() {
		$this->view->defaultToProfile();
	}

	function displayProfileUser($user = null) {
		if (is_null($user)) {
			$user = $this->model->searchInfo();
			if (is_null($user))
				Utils::redirect("/user/login");
		}
		$this->view->displayProfile($user);
	}

	function displaySettingsUser() {
		$user = $this->model->searchInfo();
		$mail = $this->model->recupMail($user);
		$this->view->displaySettings($user, $mail);
	}

	function modifySettings($name, $email, $passwd, $description) {
		if (is_null($name) || is_null($email) || is_null($description))
			Utils::error(400, "Il manque des valeurs à mettre à jour");
		$user = $this->model->searchInfo();
		if (!is_null($passwd))
			$this->model->updatePassword($passwd, $user);
		$this->model->updateSettings($name, $email, $description, $user);
		Utils::redirect("/user/profile");
	}
}
