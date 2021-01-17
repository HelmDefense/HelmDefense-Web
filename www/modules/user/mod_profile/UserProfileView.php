<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class UserProfileView extends View {
	public function displayProfile($user) { ?>
		<div class="row">
			<div id="infoName" class="col-12 col-md">
				<img id="imgProfile" alt="" src="<?= $user->avatar ?>" />
				<h3 id="pseudo"><?= $user->name ?></h3>
				<p class="font-weight-bold"><?= implode(", ", $user->ranks) ?></p>
				<p>Membre depuis le <?= Utils::formatDate($user->join_date, "d/m/Y") ?></p>
			</div>
			<div id="infoText" class="col-12 col-md">
				<h3>Description</h3>
				<p><?= $user->description ?></p>
				<h3>Dernières activités</h3>
				<div id="activities">

				</div>
			</div>
			<div class="col-12 col-xl-3 sidebar-container">
				<div class="sidebar container-fluid py-3">
					<h3>Sujets Populaires</h3>
					<h4>Sujet n°1 Discussions</h4>
					<p></p>
					<h4>Sujet n°1 Stratégies</h4>
					<p></p>
					<h4>Sujet n°1 Avis</h4>
					<p></p>
				</div>
			</div>
		</div>
	<?php }

	public function displaySettings($user, $mail) { ?>
		<div class="row">
			<div id="infoName" class="col-12 col-md">
				<img id="imgProfile" alt="" src="<?= $user->avatar ?>" />
				<button name="deleteAccount">Supprimer le compte</button>
			</div>
			<form method="post">
				<div id="infoText" class="col-12 col-md">
					<div class="row">
						<div class="col">
							<input id="name" name="name" type="text" value="<?= $user->name ?>" placeholder="" required />
							<label for="name">Pseudo</label>
						</div>
						<div class="col">
							<input id="email" name="email" type="email" value="<?= $mail ?>" placeholder="" required />
							<label for="email">E-mail</label>
						</div>
						<div class="col">
							<input id="oldpassword" name="oldpassword" type="password" placeholder="" />
							<label for="oldpassword">mot de passe actuel</label>
						</div>
						<div class="col">
							<input id="newpassword" name="newpassword" type="password" placeholder="" />
							<label for="newpassword">nouveau mot de passe</label>
						</div>
						<div class="col">
							<input id="newpasswordconfirm" name="newpasswordconfirm" type="password" placeholder="" />
							<label for="newpasswordconfirm">confirmer nouveau mot de passe</label>
						</div>
					</div>
					<h3>Description</h3>
					<textarea id="description" name="description" placeholder="" required></textarea>
					<label class="sr-only" for="description">Description</label>
					<?= Utils::renderComponent("markdowneditor", "#description", $user->description, array("placeholder" => "Description")) ?>
					<input type="hidden" name="check" value="valid" />
					<input type="submit" value="Enregistrer" />
				</div>
			</form>
		</div>
	<?php }

	public function defaultToProfile() { ?>
		<script>
			window.history.replaceState(null, null, "/user/profile");
		</script>
	<?php }
}
