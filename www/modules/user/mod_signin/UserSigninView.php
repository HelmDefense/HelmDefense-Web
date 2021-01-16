<?php
namespace Module;

use Utils;

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
					default:
						echo "Il y a eu une erreur lors de votre inscription";
						break;
					}
					?>
					<button class="close" data-dismiss="alert"><span>&times;</span></button>
				</div>
			<?php } ?>

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

				<div class="custom-input">
					<input id="password" name="password" type="password" placeholder="" required />
					<label for="password">Mot de passe</label>
				</div>

				<div class="custom-input">
					<input id="passwordconfirm" name="passwordconfirm" type="password" placeholder="" required />
					<label for="passwordconfirm">Confirmation du mot de passe</label>
				</div>

				<input type="hidden" name="check" value="valid" />
				<div class="text-center text-lg-right">
					<input id="submit" type="submit" value="Inscritpion" />
				</div>
			</form>

			<div class="text-center">
				<a href="/user/login">Déjà inscrit ? Se connecter</a>
			</div>
		</div>
	<?php }
}
