<?php

namespace model;

require_once("src/dal/CommentDAL.php");

class CommentHandler {

	private $commentDAL;

	public function __construct(\mysqli $mysqli) {
		$this->commentDAL = new \dal\CommentDAL($mysqli);
	}

	public function getAllComments() {
		return $this->commentDAL->getAllComments();
	}

	public function createComment(\model\Comment $validComment) {
		$this->commentDAL->createComment($validComment);
	}

	public function removeComment($commentID) {

		try {
			$this->commentDAL->getComment($commentID);
			$this->commentDAL->deleteComment($commentID);
		} catch(\Exception $e) {
			throw $e;
			
		}
	}
}