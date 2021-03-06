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

	private function user() {
		$user = $this->model->searchInfo();
		if (is_null($user))
			Utils::redirect("/user/login");
		return $user;
	}

	public function correctUrl() {
		$this->view->defaultToProfile();
	}

	public function displayProfileUser($user = null) {
		if (is_null($user)) {
			$user = $this->user();
		} else
			$this->title = $user->name;
		$this->view->displayProfile($user);
	}

	public function displaySettingsUser($error = 0) {
		$user = $this->user();
		$mail = $this->model->recupMail($user);
		$this->view->displaySettings($user, $mail, $error);
		$this->title = "Paramètres";
	}

	public function modifySettings($name, $email, $oldpassword, $newpassword, $newpasswordconfirm, $description) {
		if (is_null($name) || is_null($email) || is_null($description))
			Utils::error(400, "Il manque des valeurs à mettre à jour");
		$user = $this->user();
		$this->model->updateSettings($name, $email, $description, $user);
		if (!is_null($newpassword) || !is_null($newpasswordconfirm) || !is_null($oldpassword)) {
			if (is_null($newpassword) || is_null($newpasswordconfirm) || is_null($oldpassword))
				$this->displaySettingsUser(1);
			else if (!$this->model->passwordCheck($oldpassword, $user))
				$this->displaySettingsUser(2);
			else if ($newpassword != $newpasswordconfirm)
				$this->displaySettingsUser(3);
			else {
				$this->model->updatePassword($newpassword, $user);
				Utils::redirect("/user/profile");
			}
		} else
			Utils::redirect("/user/profile");
	}

	public function modifyAvatar($avatar) {
		if ($avatar->size > 1000000)
			Utils::error(400, "Le fichier est trop volumineux");
		if (strpos($avatar->type, "image/") != 0)
			Utils::error(400, "Le fichier n'est pas une image");
		if ($avatar->error == 0 && $this->model->modifyAvatar($avatar, $this->user()))
			Utils::redirect("/user/profile");
		else
			Utils::error(400, "Une erreur est survenue lors du transfert du fichier");
	}

	public function deleteAccount($password) {
		if ($this->model->deleteAccount($password, $this->user()))
			Utils::redirect("/");
		else
			Utils::error(400, "Le compte n'a pas pu être supprimé suite à une erreur. Le mot de passe est-il correct ?");
	}
}
