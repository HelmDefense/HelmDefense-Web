<?php
namespace Module;

include_once "modules/generic/View.php";

class UserSigninView extends View {
	public function resetPasswordRequested($email) { ?>
		<div class="container">
			<?php if (is_null($email)) { ?>
				<h3>Nous n'avons pas pu vous envoyer d'email de confirmation. Veuillez réessayer</h3>
			<?php } else { ?>
				<h3>Un mail a été envoyé à l'adresse : <?= $email ?></h3>
			<?php } ?>
			<p>Vous pouvez fermer cet onglet</p>
		</div>
	<?php }

	public function resetPassword() {
		Utils::addResource("<link rel='stylesheet' href='/data/css/form.css' />"); ?>
		<div class="container">
			<h2>Réinitialisation du mot de passe</h2>
			<form method="post">
				<div class="custom-input">
					<input id="id" name="id" type="text" placeholder="" value="" required />
					<label for="id">Identifiant</label>
				</div>
				<div class="custom-input">
					<input id="password" name="password" type="password" placeholder="" value="" required />
					<label for="password">Mot de passe</label>
				</div>
				<div class="text-center text-lg-right">
					<input id="submit" type="submit" value="Inscritpion" />
				</div>
			</form>
		</div>
	<?php }

	public function signin($id = null, $name = null, $email = null, $error = 0) {
		Utils::addResource("<link rel='stylesheet' href='/data/css/form.css' />"); ?>
		<div class="container">
			<h2>Inscription</h2>

			<form method="post">
				<div class="custom-input">
					<input id="email" name="email" type="text" placeholder="" value="<?= $email ?>" required />
					<label for="email">Email</label>
				</div>

				<div class="custom-input">
					<input id="id" name="id" type="text" placeholder="" value="<?= $id ?>" required />
					<label for="id">Identifiant</label>
				</div>

				<div class="custom-input">
					<input id="name" name="name" type="text" placeholder="" value="<?= $name ?>" required />
					<label for="name">Nom</label>
				</div>

				<div id="pswrd-container" class="col-12 col-lg-6">
					<div class="custom-input">
						<input id="password" name="password" type="password" placeholder="" required />
						<label for="password">Mot de passe</label>
					</div>
				</div>

				<div id="pswrd-container" class="col-12 col-lg-6">
					<div class="pswrd-input">
						<input id="passwordConfirm" name="passwordConfirm" type="password" placeholder="" required />
						<label for="passwordConfirm">Confirmation du mot de passe</label>
					</div>
				</div>

				<input type="hidden" name="check" value="valid"/>
				<div id="submit-container" class="text-center text-lg-right">
					<input id="submit" name="submit" type="submit" placeholder="" value="Inscritpion" required />
				</div>
			</form>

			<div class="col-12 col-lg-6">
				<div>
					<a href="http://helmdefense/user/login">Déjà inscrit ? Se connecter</a>
				</div>
			</div>
		</div>
	<?php }
}
