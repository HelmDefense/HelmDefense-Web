<div class="container my-5">
	<?php
	$contact = Utils::postMany(array("check", "nom", "email", "objet", "message"), true);

	if ($contact->check == "ok") {

		$valid = true;
		foreach ($contact as $key=>$value) {

			if (is_null($value) || empty($value)) {
				$valid = false;
				?>

				<div class="alert alert-warning" role="alert">

					Vous n'avez pas renseigné le champ : "<?= $key?>" !
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

				</div>
		<?php }
		}

		if ($valid) {
			if (@mail("contact@helmdefense.theoszanto.fr", $contact->objet, $contact->message, "From: $contact->nom <$contact->email>")) { ?>
				<div class="alert alert-success" role="alert">
					Votre message a bien été envoyé !
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php }

			else { ?>
				<div class="alert alert-danger" role="alert">
					Votre message n'a pas pu être envoyé !
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php }
		}
	}
	?>
</div>

<h2>Contact</h2>

<div class="container">

	<p id="required-legend">Les champs marqués d'une étoile sont requis</p>

	<form class="form" method="post">

		<input type="hidden" name="check" value="ok">

		<div class="row">
			<div id="nom-container" class="col-12 col-lg-6">
				<div class="custom-input">
					<input id="nom" name="nom" type="text" placeholder="" required />
					<label for="nom">Nom</label>
				</div>
			</div>

			<div id="email-container" class="col-12 col-lg-6">
				<div class="custom-input">
					<input id="email" name="email" type="email" placeholder="" required />
					<label for="email">Email</label>
				</div>
			</div>
		</div>

		<div id="objet-container">
			<div class="custom-input">
				<input id="objet" name="objet" type="text" placeholder="" required />
				<label for="objet">Objet</label>
			</div>
		</div>

		<div id="message-container">
			<div class="custom-input">
				<textarea id="message" name="message" placeholder="" required ></textarea>
				<label for="message">Message</label>
			</div>
		</div>

		<div id="submit-container" class="text-center text-lg-right">
			<input id="submit" name="submit" type="submit" placeholder="" required />
		</div>

	</form>

</div>