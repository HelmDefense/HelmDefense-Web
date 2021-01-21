<?php
namespace Module;

use Utils;

class UserSigninView extends View {
	public function resetPassword() {
		Utils::addResource("<link rel='stylesheet' href='/data/css/form.css' />"); ?>
		<div class="container">
			<div id="message-container" class="mt-5"></div>
			<h2>Réinitialisation du mot de passe</h2>
			<form id="password-reset-form" method="post" data-require-captcha>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="id" name="id" type="text" placeholder="" required />
						<label for="id">Identifiant</label>
					</div>
				</div>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="password" name="password" type="password" placeholder="" required />
						<label for="password">Nouveau mot de passe</label>
					</div>
				</div>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="passwordconfirm" name="passwordconfirm" type="password" placeholder="" required />
						<label for="passwordconfirm">Confirmation du mot de passe</label>
					</div>
				</div>
				<?= Utils::renderComponent("captcha", "#password-reset-form", "d-flex justify-content-center justify-content-lg-end custom-input-container") ?>
				<input type="hidden" name="check" value="valid" />
				<div class="custom-input-container text-center text-lg-right">
					<input class="btn sub-btn" type="submit" value="Envoyer une demande" />
				</div>
			</form>
			<div class="text-center my-5">
				<a class="important inverted" href="/user/login">Un éclair de génie ? Se connecter</a>
			</div>
		</div>
	<?php }

	public function resetPasswordRequested($email) { ?>
		<div class="container text-center py-5">
			<?php if (is_null($email)) { ?>
				<h3>Nous n'avons pas pu vous envoyer d'email de confirmation. Veuillez réessayer</h3>
				<a class="btn sub-btn mt-5" href="/user/signin/resetpassword">Nouvelle demande</a>
			<?php } else { ?>
				<h3>Un mail a été envoyé à l'adresse : <span class="badge sub-badge"><?= $email ?></span></h3>
				<p class="mt-5">Vous pouvez fermer cet onglet</p>
			<?php } ?>
		</div>
	<?php }

	public function resetPasswordResult($success) { ?>
		<div class="container text-center py-5">
			<?php if ($success) { ?>
				<h3>Votre mot de passe a bien été réinitialisé</h3>
				<a class="btn sub-btn mt-5" href="/user/login">Se connecter</a>
			<?php } else { ?>
				<h3>Erreur : Ce code est invalide ou a expiré</h3>
				<a class="btn sub-btn mt-5" href="/user/signin/resetpassword">Nouvelle demande</a>
			<?php } ?>
		</div>
	<?php }

	public function signin($id = null, $name = null, $email = null, $error = 0) {
		Utils::addResource("<link rel='stylesheet' href='/data/css/form.css' />"); ?>
		<div class="container">
			<div id="message-container" class="mt-5">
				<?php if ($error) { ?>
					<div class="alert alert-danger">
						<?php
						switch ($error) {
						case 1:
							echo "Votre login ou adresse email est déjà utilisé";
							break;
						case 2:
							echo "Votre login doit être alpha-numérique entre 3 et 32 caractères";
							break;
						case 3:
							echo "Vous n'avez pas précisé votre login";
							break;
						case 4:
							echo "Vous n'avez pas précisé votre mot de passe";
							break;
						case 5:
							echo "Vous n'avez pas précisé votre email";
							break;
						case 6:
							echo "Vous n'avez pas confirmé votre mot de passe";
							break;
						case 7:
							echo "Confirmation du mot de passe invalide";
							break;
						case 8:
							echo "Votre adresse mail n'est pas sous le bon format";
							break;
						case 9:
							echo "Vous n'avez pas précisé votre nom";
							break;
						case 10:
							echo "Le captcha n'a pas été complété";
							break;
						case 11:
							echo "L'email n'a pas pu être envoyé mais le compte est créé";
							break;
						default:
							echo "Il y a eu une erreur lors de votre inscription";
							break;
						}
						?>
						<button class="close" data-dismiss="alert"><span>&times;</span></button>
					</div>
				<?php } ?>
			</div>

			<h2>Inscription</h2>

			<form id="signin-form" method="post" data-require-captcha>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="email" name="email" type="text" placeholder="" value="<?= $email ?>" required />
						<label for="email">Email</label>
					</div>
				</div>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="id" name="id" type="text" placeholder="" value="<?= $id ?>" required />
						<label for="id">Identifiant</label>
					</div>
				</div>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="name" name="name" type="text" placeholder="" value="<?= $name ?>" required />
						<label for="name">Nom</label>
					</div>
				</div>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="password" name="password" type="password" placeholder="" required />
						<label for="password">Mot de passe</label>
					</div>
				</div>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="passwordconfirm" name="passwordconfirm" type="password" placeholder="" required />
						<label for="passwordconfirm">Confirmation du mot de passe</label>
					</div>
				</div>
				<?= Utils::renderComponent("captcha", "#signin-form", "d-flex justify-content-center justify-content-lg-end custom-input-container") ?>
				<input type="hidden" name="check" value="valid" />
				<div class="custom-input-container text-center text-lg-right">
					<input class="btn sub-btn" type="submit" value="Inscription" />
				</div>
			</form>
			<div class="text-center my-5">
				<a class="important inverted" href="/user/login">Déjà inscrit ? Se connecter</a>
			</div>
		</div>
	<?php }
}
