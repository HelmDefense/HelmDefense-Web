<?php
namespace Module;

use PDO;
use stdClass;
use Utils;

class PanelModoModel extends Model {

	public function users($p, $limit) {
		$offset = ($p - 1) * $limit;
		$users = new stdClass();
		self::$bdd->beginTransaction();
		$users->result = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS id, login, name, avatar, joined_at FROM hd_user_users LIMIT $offset, $limit");
		$users->count = Utils::executeRequest(self::$bdd, "SELECT found_rows() AS total", array(), false, PDO::FETCH_COLUMN);
		self::$bdd->commit();
		$users->sanctions = Utils::executeRequest(self::$bdd, "SELECT s.type, s.user, s.date, s.reason, u.name FROM hd_user_sanctions AS s INNER JOIN hd_user_users AS u ON s.moderator = u.id ORDER BY s.date DESC");
		return $users;
	}

	public function addSanction($id, $type, $reason) {
		$email = Utils::executeRequest(self::$bdd, "SELECT email FROM hd_user_users WHERE id = :id", array("id" => $id), false, PDO::FETCH_COLUMN);
		if(!$email)
			return false;
		$mod = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_user_users WHERE login = :login", array("login" => Utils::session("login")), false, PDO::FETCH_COLUMN);
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_user_sanctions (type, user, reason, moderator) VALUES (:type, :user, :reason, :moderator)", array("type" => $type, "user" => $id, "reason" => $reason, "moderator" => $mod));

		$sanction = '';
		switch ($type){
			case 1:
				$sanction = "avertissement";
				break;
			case 2:
				$sanction = "bannissement";
				break;
		}
		return mail($email, "Sanction appliquée - Helm Defense", "Bonjour,\r\nVous avez subi un $sanction pour la raison suivante : '$reason'.\r\nIl faudra apprendre à vivre en société pour combattre correctement les orcs à l'assaut du Gouffre de Helm !", "From: Helm Defense <helmdefense@theoszanto.fr>");
	}
}
