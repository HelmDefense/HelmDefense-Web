<?php
namespace Module;

include_once "modules/generic/View.php";

class UserLoginView extends View {
	public function loginPage(){
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

	public function loginError(){

	?>
		<div class="alert alert-danger" role="alert"> Il y a une erreur dans votre mot de passe et/ou dans votre nom </div>
	<?php
	}

}