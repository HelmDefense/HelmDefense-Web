<?php
namespace Module;

use Utils;

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
		} else
			$this->title = $user->name;
		$this->view->displayProfile($user);
	}

	function displaySettingsUser() {
		$user = $this->model->searchInfo();
		$mail = $this->model->recupMail($user);
		$this->view->displaySettings($user, $mail);
		$this->title = "Paramètres";
	}

	function modifySettings($name, $email, $oldpassword, $newpassword, $newpasswordconfirm, $description) {
		if (is_null($name) || is_null($email) || is_null($description))
			Utils::error(400, "Il manque des valeurs à mettre à jour");
		$user = $this->model->searchInfo();
		// TODO Vérifier $oldpassword et $newpasswordconfirm
		if (!is_null($newpassword))
			$this->model->updatePassword($newpassword, $user);
		$this->model->updateSettings($name, $email, $description, $user);
		Utils::redirect("/user/profile");
	}
}
