<?php
namespace Module;

include_once "modules/generic/View.php";

class UserSigninView extends View{
	public function signin($error = 0){
		?>

		<div class="container">
			<h2>Connexion</h2>

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
						<input id="password-confirm" name="password-confirm" type="password" placeholder="" required />
						<label for="password-confirm">Confirmation du mot de passe</label>
					</div>
				</div>

				<input type="hidden" name="check" value="valid"/>
				<div id="submit-container" class="text-center text-lg-right">
					<input id="submit" name="submit" type="submit" placeholder="" value="Connexion" required />
				</div>
			</form>

			<div class="col-12 col-lg-6">
				<div>
					<a href="">Déjà inscri ? Se connecter</a>
				</div>
			</div>
		</div>

		<?php
	}
}