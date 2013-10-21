<?php

namespace model;

/**
 * @todo Ssanitize and Tags
 */
class ValidComment {

	private $author;
	private $email;
	private $website;
	private $comment;
	private $postID;

	public function __construct($author, $email, $website, $comment, $postID) {
		if ($this->authorIsOK($author)) {
			$this->author = $author;
		} else {
			throw new \Exception("ValidComment::__construct : Bad Author");
		}

		if ($this->emailIsOK($email)) {
			$this->email = $email;
		} else {
			throw new \Exception("ValidComment::__construct : Bad Email");
		}

		//ska ha validering, typ noTags m.m
		$this->website = $website;

		if ($this->commentIsOK($comment)) {
			$this->comment = $comment;
		} else {
			throw new \Exception("ValidComment::__construct : Bad comment");
		}
		//ska ha validering?
		$this->postID = $postID;
	}


	public function authorIsOK($author) {
		if (strlen($author) < 3) {
			return false;
		}
		return true;
	}


	public function emailIsOK($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return false;
		}
		return true;
	}

	public function commentIsOK($comment) {
		if (strlen($comment) < 5) {
			return false;
		}
		return true;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getComment() {
		return $this->comment;
	}

	public function getWebsite() {
		return $this->website;
	}

	public function getPostID() {
		return $this->postID;
	}
}