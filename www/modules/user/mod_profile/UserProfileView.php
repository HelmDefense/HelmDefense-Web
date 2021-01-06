<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class UserProfileView extends View {

	public function displayProfil() { ?>
		<div id="infoName">
			<img id="imgProfile" alt="" src=""/>
			<h2 id="pseudo"></h2>
			<p>Grade</p>
			<p>Membre depuis le </p>
		</div>
		<div id="infoText">
			<h3>Description</h3>
			<p></p>
			<h3>Dernières activités</h3>
			<div id="activities">

			</div>
		</div>
		<div id="sidebar">
			<h3>Sujets populaires</h3>
			<div id="subject">

			</div>
			<p>Activité récente du forum</p>
			<div id="forumActivities">
				
			</div>
		</div>
	<?php }

}