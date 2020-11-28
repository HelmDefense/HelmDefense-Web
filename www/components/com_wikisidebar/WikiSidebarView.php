<?php
namespace Component;

use DateTime;
use DateTimeZone;
use Exception;
use Utils;

include_once "components/generic/View.php";

class WikiSidebarView extends View {
	public function sidebar($sidebarText, $recentActions) { ?>
			<div class="container-fluid py-3" style="background-color: var(--fg-color); height: calc(100vh - 200px); overflow-y: auto;">
				<div class="p-4">
					<div class="text-justify">
						<?php
							$sidebar = Utils::loadComponent("markdowntext", false, $sidebarText);
							$sidebar->generateRender();
							$sidebar->display();
						?>
					</div>
					<h3 class="mt-5 mb-4">Activité récente du Wiki</h3>
					<div>
						<?php foreach ($recentActions as $action) { ?>
							<h4><a class="text-reset" href="/wiki/page/<?= $action->page_id ?>"><?= $action->title ?></a></h4>
							<div><a class="text-reset" href="/user/profile/<?= $action->author_id ?>"><?= $action->author ?></a> - <?= $this->formatDateDiff($action->date) ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
	<?php }

	public function formatDateDiff($date) {
		try {
			$old = new DateTime($date);
			$now = new DateTime("now", new DateTimeZone("Europe/Paris"));
			$diff = $old->diff($now);
			if ($diff->s < 1)
				return "Il y a un instant";
			if ($diff->i < 1)
				return $diff->format("Il y a %s seconde" . ($diff->s > 1 ? "s" : ""));
			if ($diff->h < 1)
				return $diff->format("Il y a %i minute" . ($diff->i > 1 ? "s" : ""));
			if ($diff->d < 1)
				return $diff->format("Il y a %h heure" . ($diff->h > 1 ? "s" : ""));
			if ($diff->m < 1)
				return $diff->format("Il y a %d jour" . ($diff->d > 1 ? "s" : ""));
			if ($diff->y < 1)
				return $diff->format("Il y a %m mois et %d jour" . ($diff->d > 1 ? "s" : ""));
			return $diff->format("Il y a %y an" . ($diff->y > 1 ? "s" : ""));
		} catch (Exception $e) {
			return "Date inconnue";
		}
	}
}
