<?php

namespace model;



class Post {

	/**
	 * @todo datum, m.m
	 */

	private $author;

	/**
	 * @var string
	 */
	private $postID;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var string
	 */
	private $createDate;

	private $categories;

	private $comments;

	/**
	 * @param [type] $title [description]
	 * @param [type] $body  [description]
	 */
	public function __construct($postID, $author, $title, $content, $createDate, $categories, $comments) {

		if ($this->titleIsOK($title)) {
			$this->title = $title;
		} else {
			throw new \Exception("Post::__construct : Bad Title");
		}

		if ($this->contentIsOK($content)) {

			$this->content = $content;
		} else {
			throw new \Exception("Post::__construct : Bad Content");
		}

		$this->postID = $postID;
		$this->author = $author;
		$this->createDate = $createDate;
		$this->categories = $categories;
		$this->comments = $comments;
	}

	public static function createNewPost($title, $content, $categories) {
		return new \model\Post(null, $_SESSION["username"], $title, $content, null, $categories, null);
	}

	public static function createPostFromDB($postID, $author, $title, $content, $createDate, $categories, $comments) {
		if ($postID == null) {
			throw new \Exception("Post::createPostFromDB : Post do not exist! (null)");
		}

		return new \model\Post($postID, $author, $title, $content, $createDate, $categories, $comments);
	}

	/**
	 * @todo inte hämta author från session här.
	 * @param  [type] $id      [description]
	 * @param  [type] $title   [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public static function savePost($id, $title, $content) {
		return new \model\Post($id, $_SESSION["username"], $title, $content, null, null, null);
	}

	public function titleIsOK($title) {
		if (strlen($title) < 1) {
			return false;
		}
		if ($title != strip_tags($title)) {
			return false;
		}
		return true;
	}

	public function contentIsOK($content) {
		if (strlen($content) < 1) {
			return false;
		}
		return true;
	}

	/**
	 * @return [type] [description]
	 */
	public function getId() {
		return $this->postID;
	}

	/**
	 * @return [type] [description]
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * @return [type] [description]
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return [type] [description]
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @return [type] [description]
	 */
	public function getCreateDate() {
		return $this->createDate;
	}

	public function getComments() {
		return $this->comments;
	}

	public function getCategories() {
		return $this->categories;
	}

}