<?php
namespace Module;

use Utils;

class UserLoginView extends View {
	public function login($error = 0) {
		Utils::addResource("<link rel='stylesheet' href='/data/css/form.css' />"); ?>
		<div class="container">
			<?php if ($error) { ?>
				<div class="alert alert-danger">
					<?php
					switch ($error) {
					case 1:
						echo "Votre login est inconnu";
						break;
					case 2:
						echo "Votre mot de passe est incorrect";
						break;
					case 3:
						echo "Identifiant non indiqué";
						break;
					case 4:
						echo "Mot de passe non indiqué";
						break;
					case 5:
					default:
						echo "Il y a eu une erreur lors de votre authentification";
						break;
					}
					?>
					<button class="close" data-dismiss="alert"><span>&times;</span></button>
				</div>
			<?php } ?>

			<h2>Connexion</h2>

			<form method="post">
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="user" name="user" type="text" placeholder="" required />
						<label for="user">Identifiant</label>
					</div>
				</div>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="password" name="password" type="password" placeholder="" required />
						<label for="password">Mot de passe</label>
					</div>
				</div>
				<div class="text-center">
					<a href="/user/signin/resetpassword">Mot de passe oublié ?</a>
				</div>
				<input type="hidden" name="check" value="valid" />
				<div class="custom-input-container text-center text-lg-right">
					<input class="btn sub-btn" type="submit" value="Connexion" />
				</div>
			</form>
			<div class="text-center my-5">
				<a class="important inverted" href="/user/signin">Première visite ? Créer un compte</a>
			</div>
		</div>
	<?php }
}
