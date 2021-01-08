<?php
namespace Component;

use Utils;

include_once "components/generic/View.php";

class ForumPostListView extends View {
	public function displayTopicList($topics) {
		$this->displayTable(array("Sujet", "Auteur", "Nombre de messages", "Date de création", "Dernière activité"), function() use ($topics) {
			foreach ($topics as $topic) { ?>
				<tr>
					<td><a href="/forum/topic/<?= $topic->id ?>"><?= htmlspecialchars($topic->title) ?></a></td>
					<td><a href="/user/profile/<?= $topic->author->id ?>"><?= htmlspecialchars($topic->author->name) ?></a></td>
					<td><?= htmlspecialchars($topic->message_count) ?></td>
					<td><?= Utils::formatDate($topic->created_at) ?></td>
					<td><?= Utils::formatDate($topic->last_activity) ?></td>
				</tr>
			<?php }
		});
	}

	public function displayCommentList($comments) {
		$this->displayTable(array("Sujet", "Entité", "Note", "Auteur", "Nombre de messages", "Date de création", "Dernière activité"), function() use ($comments) {
			foreach ($comments as $comment) { ?>
				<tr>
					<td><a href="/forum/comment/<?= $comment->id ?>"><?= htmlspecialchars($comment->title) ?></a></td>
					<td><a href="/wiki/page/entity/<?= $comment->entity->id ?>"><?= htmlspecialchars($comment->entity->name) ?></a></td>
					<td><?= htmlspecialchars($comment->rate) ?></td>
					<td><a href="/user/profile/<?= $comment->author->id ?>"><?= htmlspecialchars($comment->author->name) ?></a></td>
					<td><?= htmlspecialchars($comment->message_count) ?></td>
					<td><?= Utils::formatDate($comment->created_at) ?></td>
					<td><?= Utils::formatDate($comment->last_activity) ?></td>
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
		<table class="custom-table">
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

	public function displayNavigation($type, $limit, $offset) {
		// TODO Système de navigation
	}
}
