<?php
namespace Module;

class ErrorView extends View {
	/**
	 * @param int $code
	 * @param string $status
	 * @param string $text
	 * @param string $msg
	 * @param string $background
	 * @param string|null $additional
	 */
	public function error($code, $status, $text, $msg, $background = "error", $additional = null) { ?>
			<div class="container-fluid d-flex align-items-center page-background" style="background-image: url('/data/img/<?= $background ?>-background.jpg')">
				<div class="container box page-content">
					<div class="col-md-10 mx-auto">
						<h2 class="page-title">Erreur <span class="error-code"><?= $code ?></span></h2>
						<p class="error-status"><?= $status ?></p>
						<p class="error-text"><?= $text ?></p>
						<div class="error-info">
							<p><?= $msg ?></p>
							<?php if (!is_null($additional)) echo "<p>$additional</p>"; ?>
						</div>
						<?php if ($code == 401) { ?>
							<div>
								<a class="btn main-btn error-btn" href="/user/login">Connexion</a>
							</div>
						<?php } ?>
						<a class="btn main-btn error-btn" href="/">Retour à l'accueil</a>
					</div>
				</div>
			</div>
	<?php }

	/**
	 * @param array $results
	 * @return string|null
	 */
	public function searchResults($results) {
		if (count($results)) {
			$res = array();
			foreach ($results as $result)
				$res[] = "<a class='text-reset font-weight-bold' href='/$result'>$result</a>";
			return "Peut-être vouliez-vous dire : " . implode(", ", $res);
		} else
			return null;
	}
}
