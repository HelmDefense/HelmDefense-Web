<?php
namespace Module;

include_once "modules/generic/View.php";

class UserLoginView extends View {
	public function login($error){
		if ($error){
			?>
			<div class="alert alert-danger" role="alert">
				<?php
				switch ($error){
					case 1:
						echo "Votre login est incconu";
						break;
					case 2:
						echo "votre mot de passe est incorrecte";
						break;
					default:
						echo "il y a eu une erreur lors de votre authentification";
						break;
				}
				?>
				Une erreur est survenue lors de l'authentification !
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
						<input id="id" name="id" type="text" placeholder="" required />
						<label for="id">Email ou identifiant</label>
					</div>
				</div>

				<div id="pswrd-container" class="col-12 col-lg-6">
					<div class="custom-input">
						<input id="pswrd" name="pswrd" type="password" placeholder="" required />
						<label for="pswrd">Mot de passe</label>
					</div>
				</div>

				<div id="submit-container" class="text-center text-lg-right">
					<input id="submit" name="submit" type="submit" placeholder="" value="Envoyer" required />
				</div>
			</form>

		</div>
	<?php
	}

}