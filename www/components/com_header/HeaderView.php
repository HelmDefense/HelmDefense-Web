<?php
namespace Component;

include_once "components/generic/View.php";

class HeaderView extends View {
	public function generateHeader($currentActiveNav, $panelAccess, $loggedInUsername) { ?>
			<header class="d-flex justify-content-between align-items-center">
				<a id="main-logo" class="d-flex align-items-center" href="/">
					<img src="/data/img/logo.png" alt="Logo Helm Defense" />
					<h1>Helm Defense</h1>
				</a>

				<div>
					<?php //$this->generateNav($currentActiveNav, $panelAccess, $loggedInUsername) ?>
					<a class="btn main-btn download-btn" href="/">Télécharger</a>
				</div>
			</header>
	<?php }

	/**
	 * @param string $currentActiveNav
	 * @param string[] $panelAccess
	 * @param string $loggedInUsername
	 */
	public function generateNav($currentActiveNav, $panelAccess, $loggedInUsername) { ?>
			<nav class="d-flex">
				<?php if (count($panelAccess)) { ?>
					<div class="custom-dropdown">
						<a href="/panel">Panel</a>
						<div class="custom-dropdown-content">
							<?php if (in_array("administrator", $panelAccess)) { ?>
								<a href="/panel/admin">Administration</a>
							<?php } ?>
							<?php if (in_array("developer", $panelAccess)) { ?>
								<a href="/panel/dev">Développement</a>
							<?php } ?>
							<?php if (in_array("moderator", $panelAccess)) { ?>
								<a href="/panel/modo">Modération</a>
							<?php } ?>
							<?php if (in_array("redactor", $panelAccess)) { ?>
								<a href="/panel/redac">Rédaction</a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="custom-dropdown">
					<a href="/wiki">Wiki</a>
					<div class="custom-dropdown-content">
						<a href="/wiki/entity">Entités</a>
						<a href="/wiki/level">Niveaux</a>
						<a href="/wiki/search">Recherche</a>
					</div>
				</div>
			</nav>
	<?php }
}
