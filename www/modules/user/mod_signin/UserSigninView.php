<?php
namespace Module;

include_once "modules/generic/View.php";

class UserSigninView extends View{
	public function signin($error = 0){
		if ($error){
			/* id en alpha-nmuérique (/[a-z0-9_-]{3,32}/i)
			 * duplication d'id renvoie une erreur
			 * evoyer mail pour inscription (vérifier basique email /[^@]+@[^.]+\.[^.]+/)
			 * vérification des tailles des valeurs
			 *
			 * Reset de password : Nouvelle table (user, code, date) + envoie d'un email avec code
			 * alpha-numérique aléatoire sur 32 caractères /user/signin/resetpassword/CODE
			 */
			?>
			<div class="alert alert-danger" role="alert">
				<?php
				switch ($error){
					case 7:
						echo "Confirmation du mot de passe invalide";
						break;
					default:
						echo "il y a eu une erreur lors de votre inscription";
						break;
				}
				?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<?php
		}
		?>

		<div class="container">
			<h2>Inscription</h2>

			<form class="form" method="post">
				<div id="email-container" class="col-12 col-lg-6">
					<div class="custom-input">
						<input id="email" name="email" type="text" placeholder="" required />
						<label for="email">Email</label>
					</div>
				</div>

				<div id="id-container" class="col-12 col-lg-6">
					<div class="custom-input">
						<input id="id" name="id" type="text" placeholder="" required />
						<label for="id">Identifiant</label>
					</div>
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

		<?php
	}
}