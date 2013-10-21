<?php

namespace model;

class Comment {

	private $commentID;
	private $author;
	private $email;
	private $website;
	private $comment;
	private $date;
	private $postID;

	public function __construct($commentID, $author, $email, $website, $comment, $date, $postID) {
		$this->commentID = $commentID;
		$this->author = $author;
		$this->email = $email;
		$this->website = $website;
		$this->comment = $comment;
		$this->date = $date;
		$this->postID = $postID;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function getComment() {
		return $this->comment;
	}

	public function getCreatDate() {
		return $this->date;
	}

	public function getWebsite() {
		return $this->website;
	}
}