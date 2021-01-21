<?php
namespace Module;

use Utils;

class ForumPostModule extends Module {
	public function __construct() {
		parent::__construct(new ForumPostController(), "Forum");
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$id = Utils::extra(0);
		switch (Utils::getRequired("action")) {
		case "edit":
			$message = Utils::postRequired("message");
			$this->controller->modify($id, $message);
			break;
		case "talk":
			if (is_null($id)) {
				$data = Utils::postMany(array("title", "message", "check" => "invalid"), true);
				if ($data->check == "invalid")
					$this->controller->newTalkPage();
				else
					$this->controller->newTalk($data->title, $data->message);
			} else {
				$comment = Utils::post("message");
				if (is_null($comment))
					$this->controller->talk($id);
				else
					$this->controller->postComment(1, $id, $comment);
			}
			break;
		case "rate":
			if (is_null($id)) {
				$data = Utils::postMany(array("title", "message", "entity", "rate", "check" => "invalid"), true);
				if ($data->check == "invalid")
					$this->controller->newRatePage();
				else
					$this->controller->newRate($data->title, $data->message, $data->entity, $data->rate);
			} else {
				$comment = Utils::post("message");
				if (is_null($comment))
					$this->controller->rate($id);
				else
					$this->controller->postComment(2, $id, $comment);
			}
			break;
		case "strat":
			if (is_null($id)) {
				$data = Utils::postMany(array("title", "message", "level", "hero", "entities", "check" => "invalid"), true);
				if ($data->check == "invalid")
					$this->controller->newStratPage();
				else
					$this->controller->newStrat($data->title, $data->message, $data->level, $data->hero, $data->entities);
			}
			else {
				$subAction = Utils::extra(1, "home");
				switch ($subAction) {
				case "home":
					$comment = Utils::post("message");
					if (is_null($comment))
						$this->controller->strat($id);
					else
						$this->controller->postComment(3, $id, $comment);
					break;
				case "rating":
					$data = Utils::postMany(array("rate", "comment"), true);
					$this->controller->newStratRating($id, $data->rate, $data->comment);
					break;
				default:
					Utils::error(404, "Sous-action inconnue");
				}
			}
			break;
		default:
			Utils::error(404, "Action inconnue");
		}
	}
}
