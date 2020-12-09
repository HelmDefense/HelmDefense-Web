<?php
namespace Component;

use DateTime;
use DateTimeZone;
use Exception;
use Utils;

include_once "components/generic/View.php";

class WikiSidebarView extends View {
	public function sidebar($sidebarText, $recentActions) { ?>
			<div class="wiki-sidebar container-fluid py-3">
				<div class="wiki-sidebar-inner px-4 pt-4">
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
			if ($diff->y > 0)
				return $diff->format("Il y a %y an" . ($diff->y > 1 ? "s" : ""));
			if ($diff->m > 0)
				return $diff->format("Il y a %m mois et %d jour" . ($diff->d > 1 ? "s" : ""));
			if ($diff->d > 0)
				return $diff->format("Il y a %d jour" . ($diff->d > 1 ? "s" : ""));
			if ($diff->h > 0)
				return $diff->format("Il y a %h heure" . ($diff->h > 1 ? "s" : ""));
			if ($diff->i > 0)
				return $diff->format("Il y a %i minute" . ($diff->i > 1 ? "s" : ""));
			if ($diff->s > 0)
				return $diff->format("Il y a %s seconde" . ($diff->s > 1 ? "s" : ""));
			return "Il y a un instant";
		} catch (Exception $e) {
			return "Date inconnue";
		}
	}
}
