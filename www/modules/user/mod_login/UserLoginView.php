<?php
namespace Module;

include_once "modules/generic/View.php";

class UserLoginView extends View {
	public function login($error = 0){
		if ($error){
			?>
			<div class="alert alert-danger" role="alert">
				<?php
				switch ($error){
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
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<?php
		}
	?>
		<div class="container-fluid">
			<h2>Connexion</h2>

			<form class="form" method="post">
				<div id="id-container" class="col-12 col-lg-6">
					<div class="custom-input">
						<input id="user" name="user" type="text" placeholder="" required />
						<label for="user">Email ou identifiant</label>
					</div>
				</div>

				<div id="pswrd-container" class="col-12 col-lg-6">
					<div class="custom-input">
						<input id="password" name="password" type="password" placeholder="" required />
						<label for="password">Mot de passe</label>
					</div>
				</div>

				<input type="hidden" name="check" value="valid"/>
				<div id="submit-container" class="text-center text-lg-right">
					<input id="submit" name="submit" type="submit" placeholder="" value="Connexion" required />
				</div>
			</form>

			<a href="">Mot de passe oublié ?</a>
			<a href="">Première visite ? Créer un compte</a>


		</div>
	<?php
	}
}