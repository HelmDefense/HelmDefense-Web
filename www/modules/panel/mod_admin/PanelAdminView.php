<?php
namespace Module;

use Utils;

class PanelAdminView extends View {
	public function displayList($users, $count, $limit, $p) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />");
		$total = ceil($count / $limit); ?>
		<div class="container panel-body">
			<h2>Panel d'administration</h2>
			<table class="w-100 custom-table">
				<thead>
					<tr>
						<th>Avatar</th>
						<th>ID</th>
						<th>Login</th>
						<th>Nom</th>
						<th>Mail</th>
						<th>Date d'inscription</th>
						<th>Rôles</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user) { ?>
						<tr>
							<td><img class="user-avatar" src="/data/img/avatar/<?= is_null($user->avatar) ? "default.png" : $user->avatar ?>" alt="Avatar de <?= $user->name ?>" /></td>
							<td><?= htmlspecialchars($user->id) ?></td>
							<td><a href="/panel/admin/edit/<?= $user->id ?>" data-toggle="tooltip" title="Modifier les rôles"><?= htmlspecialchars($user->login) ?></a></td>
							<td><a href="/user/profile/<?= $user->login ?>" data-toggle="tooltip" title="Voir le profil" target="_blank"><?= htmlspecialchars($user->name) ?></a></td>
							<td><a href="mailto:<?= $user->email ?>"><?= htmlspecialchars($user->email) ?></a></td>
							<td><?= Utils::formatDate($user->joined_at) ?></td>
							<td>
								<?php
								if (count($user->ranks))
									$this->userRanks($user->ranks);
								else
									echo "<span data-toggle='tooltip' title=\"L'utilisateur n'a pas de rôles\">&times;</span>";
								?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="navigation mt-4"></div>
			<script>
		        Utils.pagination.show({
		            container: $(".navigation"),
		            pages: ["<?= implode('", "', range(1, $total)) ?>"],
		            callback: page => {
		                if (page.num <= 0 || page.num > <?= $total ?>)
		                    return false;
		                window.location.href = `/panel/admin/home/${page.num}/<?= $limit ?>`;
		                return true;
		            },
		            defaultPage: <?= $p ?>,
		            triggerOnCreation: false,
		            ignoreWhenSelected: true,
		            customClass: "justify-content-center dark"
		        });
			</script>
		</div>
	<?php }

	public function userRanks($ranks) {
		foreach ($ranks as $rank) { ?>
			<span class="badge sub-badge"><?= $this->rank($rank) ?></span>
		<?php }
	}

	public function rank($rank) {
		switch ($rank) {
		case "administrator":
			return "Administrateur";
		case "moderator":
			return "Modérateur";
		case "developer":
			return "Développeur";
		case "redactor":
			return "Rédacteur";
		default:
			return "";
		}
	}

	public function displayProfileRole($user) {
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />"); ?>
		<div class="container panel-body text-center">
			<img class="panel-img" src="/data/img/avatar/<?= is_null($user->avatar) ? "default.png" : $user->avatar ?>" alt="Avatar de <?= $user->name ?>" />
			<h2 class="mt-3 mb-2"><?= $user->name ?></h2>
			<div class="important">
				<a href="mailto:<?= $user->email ?>"><?= $user->email ?></a>
			</div>
			<form method="post">
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="login" name="login" type="text" value="<?= $user->login ?>" placeholder="" required/>
						<label for="login">Login</label>
					</div>
				</div>
				<div class="important d-flex flex-column align-items-center">
					<div class="custom-control custom-switch rank-switch">
						<input type="checkbox" class="custom-control-input" id="admin" name="admin" <?= $this->isRole("administrator", $user) ?> />
						<label class="custom-control-label" for="admin">Administrateur</label>
					</div>
					<div class="custom-control custom-switch rank-switch">
						<input type="checkbox" class="custom-control-input" id="dev" name="dev" <?= $this->isRole("developer", $user) ?> />
						<label class="custom-control-label" for="dev">Développeur</label>
					</div>
					<div class="custom-control custom-switch rank-switch">
						<input type="checkbox" class="custom-control-input" id="modo" name="modo" <?= $this->isRole("moderator", $user) ?> />
						<label class="custom-control-label" for="modo">Modérateur</label>
					</div>
					<div class="custom-control custom-switch rank-switch">
						<input type="checkbox" class="custom-control-input" id="redac" name="redac" <?= $this->isRole("redactor", $user) ?> />
						<label class="custom-control-label" for="redac">Rédacteur</label>
					</div>
					<input name="check" type="hidden" value="valid" />
					<div class="row w-100">
						<div class="col-12 col-lg-6 text-center text-lg-left">
							<a class="btn sub-btn panel-btn" href="/panel/admin">Annuler</a>
						</div>
						<div class="col-12 col-lg-6 text-center text-lg-right">
							<input class="btn sub-btn panel-btn mb-0" type="submit" value="Enregistrer" />
						</div>
					</div>
				</div>
			</form>
		</div>
	<?php }

	private function isRole($str, $user) {
		if (in_array($str, $user->ranks))
			return "checked";
		else
			return "";
	}
}
