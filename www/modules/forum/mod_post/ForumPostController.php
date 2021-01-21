<?php
namespace Module;

use Utils;

class ForumPostController extends Controller {
	const LIMIT = 20;

	public function __construct() {
		parent::__construct(new ForumPostModel(), new ForumPostView());
	}

	public function verifyAccess() {
		Utils::restrictAccess(null, "Vous devez être connecté pour faire cette action", "");
	}

	public function talk($id) {
		$talk = $this->model->post("talk", $id, self::LIMIT, 1);
		if (is_null($talk))
			Utils::error(404, "Discussion inconnue");
		$this->view->talk($id, $talk, Utils::loggedInUser());
	}

	public function newTalkPage() {
		$this->verifyAccess();
		$this->view->newTalk();
	}

	public function newTalk($title, $message) {
		$this->verifyAccess();
		if (!Utils::checkCaptcha())
			Utils::error(403, "Le catcha n'a pas été complété");
		if (is_null($title) || is_null($message))
			Utils::error(400, "Il manque des informations");
		if (strlen($message) > 10000)
			Utils::error(413, "La longueur d'un des champs est trop grande");

		$id = $this->model->newTalk($title, $message);
		Utils::redirect("/forum/post/talk/$id");
	}

	public function rate($id) {
		$rate = $this->model->post("rate", $id, self::LIMIT, 1);
		if (is_null($rate))
			Utils::error(404, "Avis sur entité inconnue");
		$this->view->rate($id, $rate, Utils::loggedInUser());
	}

	public function newRatePage() {
		$this->verifyAccess();
		$this->view->newRate($this->model->entitiesWithRate());
	}

	public function newRate($title, $message, $entity, $rate) {
		$this->verifyAccess();
		if (!Utils::checkCaptcha())
			Utils::error(403, "Le catcha n'a pas été complété");
		if (is_null($title) || is_null($message) || is_null($entity) || is_null($rate))
			Utils::error(400, "Il manque des informations");
		if (strlen($message) > 10000 || $rate <= 0 || $rate > 5)
			Utils::error(413, "La longueur d'un des champs est trop grande");

		$id = $this->model->newRate($title, $message, $entity, $rate);
		if (!$id)
			Utils::error(404, "L'entité n'existe pas");
		Utils::redirect("/forum/post/rate/$id");
	}

	public function strat($id) {
		$strat = $this->model->post("strat", $id, self::LIMIT, 1);
		if (is_null($strat))
			Utils::error(404, "Stratégie inconnue");
		$this->view->strat($id, $strat, Utils::loggedInUser());
	}

	public function newStratPage() {
		$this->verifyAccess();
		$this->view->newStrat($this->model->heroes(), $this->model->levels(), $this->model->defenders());
	}

	public function newStratRating($id, $rate, $comment) {
		$this->verifyAccess();
		if (!Utils::checkCaptcha())
			Utils::error(403, "Le captcha n'a pas été complété");
		if (is_null($rate) || is_null($comment) || $rate <= 0 || $rate > 5 || strlen($comment) > 1000)
			Utils::error(400, "Il manque des informations ou certaines sont incorrectes");
		if (!$this->model->stratRating($id, $rate, $comment))
			Utils::error(404, "La stratégie n'existe pas ou vous l'avez déjà noté");
		Utils::redirect("/forum/post/strat/$id");
	}

	public function newStrat($title, $message, $level, $hero, $entities) {
		$this->verifyAccess();
		if (!Utils::checkCaptcha())
			Utils::error(403, "Le captcha n'a pas été complété");
		if (is_null($message)|| is_null($title) || is_null($level) || is_null($hero) || is_null($entities))
			Utils::error(400, "Il manque des informations");
		if (strlen($message) > 10000)
			Utils::error(413, "La longueur d'un des champs est trop grande");

		$id = $this->model->newStrat($title, $message, $level, $hero, $entities);
		if (!$id)
			Utils::error(400, "Les paramètres étaient incorrect");
		Utils::redirect("/forum/post/strat/$id");
	}

	public function postComment($type, $id, $comment) {
		$this->verifyAccess();
		if (!Utils::checkCaptcha())
			Utils::error(403, "Le captcha n'a pas été complété");
		if (!$this->model->isOpened($type, $id))
			Utils::error(403, "Le post n'est pas ouvert");
		$this->model->postComment($type, $id, $comment);

		switch ($type) {
		case 1:
			$this->talk($id);
			break;
		case 2:
			$this->rate($id);
			break;
		case 3:
			$this->strat($id);
			break;
		default :
			Utils::redirect("/forum");
			break;
		}
	}

	public function modify($id, $message) {
		$this->verifyAccess();
		if (!Utils::checkCaptcha())
			Utils::error(403, "Le captcha n'a pas été complété");
		if (is_null($message)|| is_null($id))
			Utils::error(400, "Il manque des informations");
		if (strlen($message) > 10000)
			Utils::error(413, "La longueur d'un des champs est trop grande");
		$author = $this->model->getMsgAuthor($id);
		if (!$author)
			Utils::error(404, "Le message n'existe pas");
		if ($author != Utils::loggedInUser()->id)
			Utils::error(403, "Vous ne pouvez modifier que vos propres messages");

		$this->model->modify($id, $message);
		Utils::redirect($_SERVER["HTTP_REFERER"]);
	}
}
