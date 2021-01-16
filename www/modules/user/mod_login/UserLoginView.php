<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

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
						echo "votre mot de passe est incorrect";
						break;
					case 3:
						echo "identifiant non indiqué";
						break;
					case 4:
						echo "mot de passe non indiqué";
						break;
					case 5:
					default:
						echo "il y a eu une erreur lors de votre authentification";
						break;
					}
					?>
					<button class="close" data-dismiss="alert"><span>&times;</span></button>
				</div>
			<?php } ?>

			<h2>Connexion</h2>

			<form class="form" method="post">
				<div class="custom-input">
					<input id="user" name="user" type="text" placeholder="" required />
					<label for="user">Identifiant</label>
				</div>

				<div class="custom-input">
					<input id="password" name="password" type="password" placeholder="" required />
					<label for="password">Mot de passe</label>
				</div>

				<input type="hidden" name="check" value="valid" />
				<div class="text-center text-lg-right">
					<input id="submit" type="submit" value="Connexion" />
				</div>
			</form>

			<div>
				<a href="/user/signin/resetpassword">Mot de passe oublié ?</a>
			</div>
			<div>
				<a href="/user/signin">Première visite ? Créer un compte</a>
			</div>
		</div>
	<?php }
}
