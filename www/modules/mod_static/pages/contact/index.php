<div class="container">
	<div class="my-5">
    	<?php
    	$contact = Utils::postMany(array("check", "nom", "email", "objet", "message"), true);
    	if ($contact->check == "ok") {
    		$valid = true;
    		foreach ($contact as $key => $value) {
    			if (is_null($value) || empty($value)) {
    				$valid = false; ?>
    				<div class="alert alert-warning" role="alert">
    					Vous n'avez pas renseigné le champ : "<?= $key?>" !
    					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    				</div>
    			<?php }
    		}
    		if ($valid) {
    			if (@mail("contact@helmdefense.theoszanto.fr", $contact->objet, Utils::markdown($contact->message), "From: $contact->nom <$contact->email>")) { ?>
    				<div class="alert alert-success" role="alert">
    					Votre message a bien été envoyé !
    					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    				</div>
    			<?php } else { ?>
    				<div class="alert alert-danger" role="alert">
    					Votre message n'a pas pu être envoyé !
    					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    				</div>
    			<?php }
    		}
    	}
    	?>
	</div>
	<h2>Contact</h2>
	<p class="required-legend">Les champs marqués d'une étoile sont requis</p>
	<form class="form" method="post">
		<input type="hidden" name="check" value="ok" />
		<div class="row">
			<div class="custom-input-container custom-input-container-inline col-12 col-lg-6">
				<div class="custom-input">
					<input id="nom" name="nom" type="text" placeholder="" required />
					<label for="nom">Nom</label>
				</div>
			</div>
			<div class="custom-input-container custom-input-container-inline col-12 col-lg-6">
				<div class="custom-input">
					<input id="email" name="email" type="email" placeholder="" required />
					<label for="email">Email</label>
				</div>
			</div>
		</div>
		<div class="custom-input-container">
			<div class="custom-input">
				<input id="objet" name="objet" type="text" placeholder="" required />
				<label for="objet">Objet</label>
			</div>
		</div>
		<div class="markdown-editor-container">
			<textarea id="message" name="message" placeholder="" required></textarea>
			<label class="sr-only" for="message">Message</label>
			<?= Utils::renderComponent("markdowneditor", "#message", null, array("placeholder" => "Message")) ?>
		</div>
		<div class="text-center text-lg-right">
			<input id="submit" class="btn sub-btn" name="submit" type="submit" placeholder="" value="Envoyer" required />
		</div>
	</form>
</div>
