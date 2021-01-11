<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class UserProfileView extends View {

	public function displayProfile($user) { ?>
		<div class="row">
			<div id="infoName" class="col-12 col-md">
				<img id="imgProfile" alt="" src=<?=$user->avatar?>/>
				<h3 id="pseudo"><?=$user->name?></h3>
				<p class="font-weight-bold"><?=$user->ranks?></p>
				<p>Membre depuis le <?=$user->joined_at?></p>
			</div>
			<div id="infoText" class="col-12 col-md">
				<h3>Description</h3>
				<p><?=$user->description?></p>
				<h3>Dernières activités</h3>
				<div id="activities">

				</div>
			</div>
			<div class="col-12 col-xl-3 sidebar-container">
				<div class="sidebar container-fluid py-3">
					<h3>Sujets Populaires</h3>
					<h4>Sujet n°1 Discussions</h4>
					<p></p>
					<h4>Sujet n°1 Stratégies</h4>
					<p></p>
					<h4>Sujet n°1 Avis</h4>
					<p></p>
				</div>
			</div>
		</div>
	<?php }

	public function displaySettings($user) { ?>
		<div class="row">
			<div id="infoName" class="col-12 col-md">
				<img id="imgProfile" alt="" src=<?=$user->avatar?>/>
				<h3 id="pseudo"><?=$user->name?></h3>
				<p class="font-weight-bold"><?=$user->ranks?></p>
				<p>Membre depuis le <?=$user->joined_at?></p>
			</div>
			<div id="infoText" class="col-12 col-md">
				<h3>Description</h3>
				<p><?=$user->description?></p>
				<h3>Dernières activités</h3>
				<div id="activities">

				</div>
			</div>
			<div class="col-12 col-xl-3 sidebar-container">
				<div class="sidebar container-fluid py-3">
					<h3>Sujets Populaires</h3>
					<h4>Sujet n°1 Discussions</h4>
					<p></p>
					<h4>Sujet n°1 Stratégies</h4>
					<p></p>
					<h4>Sujet n°1 Avis</h4>
					<p></p>
				</div>
			</div>
		</div>
	<?php }

	static function defaultToProfile() { ?>
		<script>
			window.history.replaceState(null, null, "/user/profile");
		</script>
	<?php }
}