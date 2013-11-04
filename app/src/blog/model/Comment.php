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

		if ($this->authorIsOK($author)) {
			$this->author = $author;
		} else {
			throw new \Exception("Comment::__construct : Bad Author");
		}

		if ($this->emailIsOK($email)) {
			$this->email = $email;
		} else {
			throw new \Exception("Comment::__construct : Bad Email");
		}

        if ($this->websiteIsOK($website)) {
			$this->website = $website;
		} else {
			throw new \Exception("Comment::__construct : Bad website");
		}

		if ($this->commentIsOK($comment)) {
			$this->comment = $comment;
		} else {
			throw new \Exception("Comment::__construct : Bad comment");
		}

		$this->date = $date;
		$this->postID = $postID;
	}

	public static function createCommentFromUser($author, $email, $website, $comment, $postID) {
		return new \model\Comment(null, $author, $email, $website, $comment, null, $postID);
	}

	public function authorIsOK($author) {
		if ($author != strip_tags($author)) {
			return false;
		}
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
	
	public function websiteIsOK($website) {
		if ($website != strip_tags($website)) {
			return false;
		}
		return true;
	}

	public function commentIsOK($comment) {
		if ($comment != strip_tags($comment)) {
			return false;
		}
		if (strlen($comment) < 5) {
			return false;
		}
		return true;
	}

	public function getID() {
		return $this->commentID;
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

	public function getCreatDate() {
		return $this->date;
	}

	public function getWebsite() {
		return $this->website;
	}

	public function getPostID() {
		return $this->postID;
	}
}