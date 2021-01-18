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
							<p class="font-weight-bold important"><?php $this->userRanks($user->ranks); ?></p>
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

	public function userRanks($ranks) {
		foreach ($ranks as $rank) { ?>
			<span class="badge sub-badge"><?= $this->rank($rank) ?></span>
		<?php }
	}

	public function rank($rank) {
		switch ($rank) {
		case "administrator":
			return "Administrateur";
		case "moderator":
			return "Modérateur";
		case "developer":
			return "Développeur";
		case "redactor":
			return "Rédacteur";
		default:
			return "";
		}
	}

	public function displaySettings($user, $email) {
		Utils::addResource("<link rel='stylesheet' href='/data/css/form.css' />"); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="profile-page col-12 col-xl-9">
					<div class="row">
						<div class="text-center col-12 col-md-4">
							<img class="w-100" src="<?= $user->avatar ?>" alt="Avatar de <?= $user->name ?>" />
							<button class="btn sub-btn small-btn mt-5" data-toggle="modal" data-target="#modify-avatar">Modifier l'avatar</button>
							<div id="modify-avatar" class="modal custom-modal fade" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Modifier votre avatar</h3>
											<button class="close" data-dismiss="modal"><span>&times;</span></button>
										</div>
										<div class="modal-body">
											<h4 class="pb-3">Avatar actuel</h4>
											<img class="w-100" src="<?= $user->avatar ?>" alt="Avatar de <?= $user->name ?>" />
											<h4 class="py-3">Nouvel avatar</h4>
											<img id="newavatar" class="w-100" src="" alt="Aucun" />
										</div>
										<div class="modal-footer">
											<form method="post" enctype="multipart/form-data" action="/user/settings/avatar">
												<div class="custom-input-container">
													<div class="custom-file">
														<input id="avatar" name="avatar" class="custom-file-input" type="file" accept="image/*" required />
														<label class="custom-file-label text-left" for="avatar" data-browse="Charger">Nouvel avatar</label>
														<script>
															$("#avatar").change(e1 => {
																let file = e1.currentTarget.files[0];
																$("label[for=avatar]").text(file.name);
																let reader = new FileReader();
																reader.onload = e2 => $("#newavatar").attr("src", e2.target.result);
																reader.readAsDataURL(file);
															});
														</script>
													</div>
												</div>
												<div class="custom-input-container">
													<input class="btn main-btn small-btn" type="submit" value="Modifier l'avatar" />
												</div>
											</form>
											<button class="btn main-btn small-btn" data-dismiss="modal">Annuler</button>
										</div>
									</div>
								</div>
							</div>
							<button class="btn sub-btn small-btn my-5" data-toggle="modal" data-target="#confirm-suppress">Supprimer le compte</button>
							<div id="confirm-suppress" class="modal custom-modal fade" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Confirmer la suppression</h3>
											<button class="close" data-dismiss="modal"><span>&times;</span></button>
										</div>
										<div class="modal-body">
											Êtes-vous sûr de confirmer la suppression de votre compte ? Cette action est irréversible !
										</div>
										<div class="modal-footer">
											<form method="post" action="/user/settings/delete">
												<div class="custom-input-container">
													<div class="custom-input">
														<input id="password" name="password" type="password" placeholder="" required />
														<label for="password">Mot de passe</label>
													</div>
												</div>
												<div class="custom-input-container text-center text-lg-right">
													<input class="btn main-btn small-btn" type="submit" value="Confirmer la suppression" />
												</div>
											</form>
											<button class="btn main-btn small-btn" data-dismiss="modal">Annuler</button>
										</div>
									</div>
								</div>
							</div>
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
											<label for="newpasswordconfirm">Confirmer le nouveau mot de passe</label>
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
