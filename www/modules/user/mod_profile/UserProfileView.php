<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class UserProfileView extends View {

	public function displayProfile() { ?>
		<div class="row">
			<div id="infoName" class="col-12 col-md">
				<img id="imgProfile" alt="" src="/data/img/avatar/indyteo.png"/>
				<h3 id="pseudo">Pseudo</h3>
				<p class="font-weight-bold">Grade</p>
				<p>Membre depuis le </p>
			</div>
			<div id="infoText" class="col-12 col-md">
				<h3>Description</h3>
				<p>Quod si rectum statuerimus vel concedere amicis, quidquid velint, vel impetrare ab iis,
					quidquid velimus, perfecta quidem sapientia si simus, nihil habeat res vitii; sed loquimur
					de iis amicis qui ante oculos sunt, quos vidimus aut de quibus memoriam accepimus, quos
					novit vita communis. Ex hoc numero nobis exempla sumenda sunt, et eorum quidem maxime qui
					ad sapientiam proxime accedunt.</p>
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