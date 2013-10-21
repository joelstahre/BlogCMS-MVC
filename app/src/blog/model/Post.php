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

	private $comments;

	/**
	 * @param [type] $title [description]
	 * @param [type] $body  [description]
	 */
	public function __construct($postID, $author, $title, $content, $createDate, $comments) {
		$this->postID = $postID;
		$this->author = $author;
		$this->title = $title;
		$this->content = $content;
		$this->createDate = $createDate;
		$this->comments = $comments;
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

}