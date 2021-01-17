<?php
namespace Module;

use Utils;

class UserProfileView extends View {
	public function displayProfile($user) { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="profile-page col-12 col-xl-9">
					<div class="row">
						<div class="text-center col-12 col-md-4">
							<img class="w-100" src="<?= $user->avatar ?>" alt="Avatar de <?= $user->name ?>" />
							<h3 class="profile-title"><?= $user->name ?></h3>
							<p class="font-weight-bold"><?= implode(", ", $user->ranks) ?></p>
							<p>Membre depuis le <?= Utils::formatDate($user->join_date, "d/m/Y") ?></p>
						</div>
						<div class="col-12 col-md-8">
							<div class="profile-content">
								<h3 class="profile-title">Description</h3>
								<?= Utils::markdown($user->description) ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-xl-3 forum-sidebar-container">
					<?= Utils::renderComponent("forumsidebar"); ?>
				</div>
			</div>
		</div>
	<?php }

	public function displaySettings($user, $email) {
		Utils::addResource("<link rel='stylesheet' href='/data/css/form.css' />"); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="profile-page col-12 col-xl-9">
					<div class="row">
						<div class="text-center col-12 col-md-4">
							<img class="w-100" src="<?= $user->avatar ?>" alt="Avatar de <?= $user->name ?>" />
							<button class="btn sub-btn my-5">Supprimer le compte</button>
						</div>
						<div class="col-12 col-md-8">
							<div class="profile-content">
								<form method="post">
									<h3 class="profile-title">Informations</h3>
									<div class="row">
										<div class="custom-input-container col-12 col-lg-6">
											<div class="custom-input">
												<input id="name" name="name" type="text" value="<?= $user->name ?>" placeholder="" required />
												<label for="name">Pseudo</label>
											</div>
										</div>
										<div class="custom-input-container col-12 col-lg-6">
											<div class="custom-input">
												<input id="email" name="email" type="email" value="<?= $email ?>" placeholder="" required />
												<label for="email">E-mail</label>
											</div>
										</div>
									</div>
									<h3 class="profile-title">Modifier le mot de passe</h3>
									<div class="custom-input-container">
										<div class="custom-input">
											<input id="oldpassword" name="oldpassword" type="password" placeholder="" />
											<label for="oldpassword">Mot de passe actuel</label>
										</div>
									</div>
									<div class="custom-input-container">
										<div class="custom-input">
											<input id="newpassword" name="newpassword" type="password" placeholder="" />
											<label for="newpassword">Nouveau mot de passe</label>
										</div>
									</div>
									<div class="custom-input-container">
										<div class="custom-input">
											<input id="newpasswordconfirm" name="newpasswordconfirm" type="password" placeholder="" />
											<label for="newpasswordconfirm">Confirmer nouveau mot de passe</label>
										</div>
									</div>
									<h3 class="profile-title">Description</h3>
									<div class="markdown-editor-container">
									    <textarea id="description" name="description" placeholder="" required></textarea>
    									<label class="sr-only" for="description">Description</label>
    									<?= Utils::renderComponent("markdowneditor", "#description", $user->description, array("placeholder" => "Description")) ?>
									</div>
									<input type="hidden" name="check" value="valid" />
									<div class="custom-input-container pb-0 text-center text-lg-right">
									    <input class="btn sub-btn" type="submit" value="Enregistrer" />
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-xl-3 forum-sidebar-container">
					<?= Utils::renderComponent("forumsidebar"); ?>
				</div>
			</div>
		</div>
	<?php }

	public function defaultToProfile() { ?>
		<script>
			window.history.replaceState(null, null, "/user/profile");
		</script>
	<?php }
}
