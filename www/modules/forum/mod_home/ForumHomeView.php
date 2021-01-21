<?php
namespace Module;

use Utils;

class ForumHomeView extends View {
	public function homePage($homeText, $limit, $loggedIn = false) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9">
						<h2 class="forum-title">Forum Helm Defense</h2>
						<div class="forum-body">
							<p>Bienvenue sur le Forum de Helm Defense.</p>
							<div class="text-justify">
								<?= Utils::markdown($homeText); ?>
							</div>
							<h3 class="section-title">Discussions</h3>
							<?php if ($loggedIn) { ?>
								<div class="text-center text-lg-left">
									<a class="btn sub-btn small-btn" href="/forum/post/talk">Nouvelle discussion</a>
								</div>
							<?php } ?>
							<div class="forum-post-list">
    							<?= Utils::renderComponent("forumpostlist", "talk", $limit) ?>
							</div>
							<div class="forum-link-container">
								<a class="forum-link" href="/forum/talk">Plus de sujets dans la catégorie Discussions</a>
							</div>
							<h3 class="section-title">Avis sur les entités</h3>
							<?php if ($loggedIn) { ?>
								<div class="text-center text-lg-left">
									<a class="btn sub-btn small-btn" href="/forum/post/rate">Nouvel avis</a>
								</div>
							<?php } ?>
							<div class="forum-post-list">
    							<?= Utils::renderComponent("forumpostlist", "rate", $limit) ?>
							</div>
							<div class="forum-link-container">
								<a class="forum-link" href="/forum/rate">Plus de sujets dans la catégorie Avis sur les entités</a>
							</div>
							<h3 class="section-title">Stratégies</h3>
							<?php if ($loggedIn) { ?>
								<div class="text-center text-lg-left">
									<a class="btn sub-btn small-btn" href="/forum/post/strat">Nouvelle stratégie</a>
								</div>
							<?php } ?>
							<div class="forum-post-list">
    							<?= Utils::renderComponent("forumpostlist", "strat", $limit) ?>
							</div>
							<div class="forum-link-container">
								<a class="forum-link" href="/forum/strat">Plus de sujets dans la catégorie Stratégies</a>
							</div>
						</div>
					</div>
					<div class="forum-sidebar-container col-12 col-xl-3">
						<?= Utils::renderComponent("forumsidebar"); ?>
					</div>
				</div>
			</div>
	<?php }

	public function postList($type, $loggedIn = false) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9">
						<h2 class="forum-title">Forum Helm Defense</h2>
						<div class="forum-body">
							<h3 class="section-title mt-0"><?= $type == "talk" ? "Discussions" : ($type == "rate" ? "Avis sur les entités" : "Stratégies") ?></h3>
							<?php if ($loggedIn) { ?>
								<div class="text-center text-lg-left">
									<a class="btn sub-btn small-btn" href="/forum/post/<?= $type ?>">Nouveau sujet</a>
								</div>
							<?php } ?>
							<div class="forum-post-list">
								<?= Utils::renderComponent("forumpostlist", $type, 15, 1, true) ?>
							</div>
						</div>
					</div>
					<div class="forum-sidebar-container col-12 col-xl-3">
						<?= Utils::renderComponent("forumsidebar"); ?>
					</div>
				</div>
			</div>
	<?php }
}
