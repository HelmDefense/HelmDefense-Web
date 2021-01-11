<?php
namespace Component;

use Utils;

class ForumSidebarView extends View {
	public function sidebar($sidebarText, $recentActions) { ?>
			<div class="forum-sidebar container-fluid py-3">
				<div class="forum-sidebar-inner px-4 pt-4">
					<div class="text-justify">
						<?= Utils::markdown($sidebarText); ?>
					</div>
					<h3 class="mt-5 mb-4">Activité récente du Forum</h3>
					<div>
						<?php foreach ($recentActions as $type => $action) { ?>
							<h4><a class="text-reset" href="/forum/<?= $type ?>/<?= $action->id ?>"><?= htmlspecialchars($action->title) ?></a></h4>
							<div><a class="text-reset" href="/user/profile/<?= $action->author->id ?>"><?= htmlspecialchars($action->author->name) ?></a> - <?= Utils::formatDateDiff($action->last_activity) ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
	<?php }
}
