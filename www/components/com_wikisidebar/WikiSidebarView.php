<?php
namespace Component;

use Utils;

include_once "components/generic/View.php";

class WikiSidebarView extends View {
	public function sidebar($sidebarText, $recentActions) { ?>
			<div class="wiki-sidebar container-fluid py-3">
				<div class="wiki-sidebar-inner px-4 pt-4">
					<div class="text-justify">
						<?= Utils::markdown($sidebarText); ?>
					</div>
					<h3 class="mt-5 mb-4">Activité récente du Wiki</h3>
					<div>
						<?php foreach ($recentActions as $action) { ?>
							<h4><a class="text-reset" href="/wiki/page/<?= $action->page_id ?>"><?= htmlspecialchars($action->title) ?></a></h4>
							<div><a class="text-reset" href="/user/profile/<?= $action->author_id ?>"><?= htmlspecialchars($action->author) ?></a> - <?= Utils::formatDateDiff($action->date) ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
	<?php }
}
