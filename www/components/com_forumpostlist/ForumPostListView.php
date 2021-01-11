<?php
namespace Component;

use Utils;

class ForumPostListView extends View {
	private static $i = 0;

	public function displayTalkList($talks) {
		$this->displayTable(array("Sujet", "Auteur", "Nombre de messages", "Date de création", "Dernière activité"), function() use ($talks) {
			foreach ($talks as $talk) { ?>
				<tr>
					<td><a href="/forum/talk/<?= $talk->id ?>"><?= htmlspecialchars($talk->title) ?></a></td>
					<td><a href="/user/profile/<?= $talk->author->id ?>"><?= htmlspecialchars($talk->author->name) ?></a></td>
					<td><?= htmlspecialchars($talk->message_count) ?></td>
					<td><?= Utils::formatDate($talk->created_at) ?></td>
					<td><?= Utils::formatDate($talk->last_activity) ?></td>
				</tr>
			<?php }
		});
	}

	public function displayRateList($rates) {
		$this->displayTable(array("Sujet", "Entité", "Note", "Auteur", "Nombre de messages", "Date de création", "Dernière activité"), function() use ($rates) {
			foreach ($rates as $rate) { ?>
				<tr>
					<td><a href="/forum/rate/<?= $rate->id ?>"><?= htmlspecialchars($rate->title) ?></a></td>
					<td><a href="/wiki/page/entity/<?= $rate->entity->id ?>"><?= htmlspecialchars($rate->entity->name) ?></a></td>
					<td><?= htmlspecialchars($rate->rate) ?></td>
					<td><a href="/user/profile/<?= $rate->author->id ?>"><?= htmlspecialchars($rate->author->name) ?></a></td>
					<td><?= htmlspecialchars($rate->message_count) ?></td>
					<td><?= Utils::formatDate($rate->created_at) ?></td>
					<td><?= Utils::formatDate($rate->last_activity) ?></td>
				</tr>
			<?php }
		});
	}

	public function displayStratList($strats) {
		$this->displayTable(array("Sujet", "Niveau", "Héros", "Auteur", "Nombre de messages", "Date de création", "Dernière activité"), function() use ($strats) {
			foreach ($strats as $strat) { ?>
				<tr>
					<td><a href="/forum/strat/<?= $strat->id ?>"><?= htmlspecialchars($strat->title) ?></a></td>
					<td><a href="/wiki/page/level/<?= $strat->level->id ?>"><?= htmlspecialchars($strat->level->name) ?></a></td>
					<td><a href="/wiki/page/entity/<?= $strat->hero->id ?>"><?= htmlspecialchars($strat->hero->name) ?></a></td>
					<td><a href="/user/profile/<?= $strat->author->id ?>"><?= htmlspecialchars($strat->author->name) ?></a></td>
					<td><?= htmlspecialchars($strat->message_count) ?></td>
					<td><?= Utils::formatDate($strat->created_at) ?></td>
					<td><?= Utils::formatDate($strat->last_activity) ?></td>
				</tr>
			<?php }
		});
	}

	private function displayTable($columns, $contentGenerator) { ?>
		<table class="custom-table post-list" data-id="<?= ++self::$i ?>">
			<thead>
				<tr>
					<?php foreach ($columns as $column) echo "<th>$column</th>"; ?>
				</tr>
			</thead>
			<tbody>
				<?php call_user_func($contentGenerator); ?>
			</tbody>
		</table>
	<?php }

	public function displayNavigation($type, $limit, $page, $total) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		Utils::addResource("<script src='/data/js/forum-post-list.js'></script>");
		$pages = ceil($total / $limit);
		?>
		<div class="navigation mt-4" data-id="<?= self::$i ?>"></div>
		<script>
			const table<?= self::$i ?> = $(".post-list[data-id=<?= self::$i ?>] tbody");
			Utils.pagination.show({
				container: $(".navigation[data-id=<?= self::$i ?>]"),
				pages: ["<?= implode('", "', range(1, $pages)) ?>"],
				callback: page => {
					if (page.num <= 0 || page.num > <?= $pages ?>)
						return false;
					Utils.ajax.getWithCache({
						url: "v1/forum/<?= $type ?>",
						data: {limit: <?= $limit ?>, page: page.num},
						callback: data => {
							forum<?= $type ?>(table<?= self::$i ?>, data.result);
							return data.count !== 0;
						},
						toApi: true
					});
					return true;
				},
				defaultPage: <?= $page ?>,
				triggerOnCreation: false,
				ignoreWhenSelected: true,
				customClass: "justify-content-center"
			});
		</script>
	<?php }
}
