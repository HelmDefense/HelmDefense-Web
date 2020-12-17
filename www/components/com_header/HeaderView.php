<?php
namespace Component;

use stdClass;

include_once "components/generic/View.php";

class HeaderView extends View {
	/**
	 * @param string $currentActiveNav
	 * @param stdClass $user
	 */
	public function generateHeader($currentActiveNav, $user) { ?>
			<header class="d-flex justify-content-between align-items-center">
				<div id="header-background"></div>
				<a id="main-logo" class="d-flex align-items-center" href="/">
					<img src="/data/img/logo.png" alt="Logo Helm Defense" />
					<h1 class="d-none d-md-block">Helm Defense</h1>
				</a>

				<div class="d-flex justify-content-end align-items-center h-100">
					<nav class="d-flex flex-column flex-lg-row justify-content-end align-items-center hidden">
						<?php if (!is_null($user) && count($user->ranks)) { ?>
							<div class="custom-dropdown">
								<a class="main-nav <?php if ($currentActiveNav == "panel") echo "custom-dropdown-active"; ?>" href="/panel"><span class="main-nav-label">Panel</span></a>
								<div class="custom-dropdown-content">
									<?php if (in_array("administrator", $user->ranks)) { ?>
										<a href="/panel/admin">Administration</a>
									<?php } ?>
									<?php if (in_array("developer", $user->ranks)) { ?>
										<a href="/panel/dev">Développement</a>
									<?php } ?>
									<?php if (in_array("moderator", $user->ranks)) { ?>
										<a href="/panel/modo">Modération</a>
									<?php } ?>
									<?php if (in_array("redactor", $user->ranks)) { ?>
										<a href="/panel/redac">Rédaction</a>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
						<div class="custom-dropdown">
							<a class="main-nav <?php if ($currentActiveNav == "wiki") echo "custom-dropdown-active"; ?>" href="/wiki"><span class="main-nav-label">Wiki</span></a>
							<div class="custom-dropdown-content">
								<a href="/wiki/search">Recherche</a>
								<a href="/wiki/entity">Entités</a>
								<a href="/wiki/level">Niveaux</a>
							</div>
						</div>
						<div class="custom-dropdown">
							<a class="main-nav <?php if ($currentActiveNav == "forum") echo "custom-dropdown-active"; ?>" href="/forum"><span class="main-nav-label">Forum</span></a>
							<div class="custom-dropdown-content">
								<a href="/forum/search">Recherche</a>
								<a href="/forum/talk">Discussions</a>
								<a href="/forum/strat">Stratégies</a>
								<a href="/forum/rate">Avis</a>
							</div>
						</div>
						<a class="main-nav <?php if ($currentActiveNav == "contact") echo "custom-dropdown-active"; ?>" href="/contact">Contact</a>
						<?php if (!is_null($user)) { ?>
							<div class="custom-dropdown">
								<a class="main-nav <?php if ($currentActiveNav == "user") echo "custom-dropdown-active"; ?>" href="/user"><img class="user-avatar" src="<?= $user->avatar ?>" alt="<?= $user->name ?>" /></a>
								<div class="custom-dropdown-content">
									<a href="/user/profile">Profil</a>
									<a href="/user/settings">Paramètres</a>
									<a href="/user/logout">Déconnexion</a>
								</div>
							</div>
						<?php } else { ?>
							<a class="main-nav <?php if ($currentActiveNav == "user") echo "custom-dropdown-active"; ?>" href="/user/login">Connexion</a>
						<?php } ?>
					</nav>
					<div id="navbar-toggle" class="">
						<div id="menu-bar-1"></div>
						<div id="menu-bar-2"></div>
						<div id="menu-bar-3"></div>
					</div>
					<script>
						const menu = document.getElementById("navbar-toggle");
						menu.addEventListener("click", () => {
							menu.classList.toggle("cross-menu");
							document.querySelector("nav").classList.toggle("hidden");
						});
					</script>
					<a class="btn main-btn download-btn d-none d-xl-block" href="/download">Télécharger</a>
				</div>
			</header>
	<?php }
}
