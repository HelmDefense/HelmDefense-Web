<?php
namespace Module;

include_once "modules/generic/View.php";

class UserSigninView extends View{
	public function signin($error = 0){
		?>
			<p>Je suis l'inscription</p>
		<?php
	}
}